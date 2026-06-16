const Referral = require('../models/Referral');
const User = require('../models/User');

// Grade-based reward configuration
const REWARD_CONFIG = {
    12: {
        referralsRequired: 10,
        reward: 'fee_refund',
        rewardLabel: '100% Fee Refund',
        description: 'Refer 10 students and get a full refund of your Class 12 admission fee.',
    },
    10: {
        referralsRequired: 10,
        reward: 'free_class12_admission',
        rewardLabel: 'Free Class 12 Admission',
        description: 'Refer 10 students and unlock free admission to Class 12.',
    },
};

// @desc    Get current user's referrals + reward progress
// @route   GET /api/referrals/me
// @access  Private
exports.getMyReferrals = async (req, res, next) => {
    try {
        const referrals = await Referral.find({ referrerId: req.user.id }).populate(
            'referredUserId',
            'name email createdAt'
        );

        const grade = req.user.grade;
        const config = REWARD_CONFIG[grade] || null;
        const referralsCount = req.user.referralsCount || 0;

        let rewardStatus = null;
        if (config) {
            const remaining = Math.max(0, config.referralsRequired - referralsCount);
            rewardStatus = {
                grade,
                reward: config.reward,
                rewardLabel: config.rewardLabel,
                description: config.description,
                referralsRequired: config.referralsRequired,
                referralsCount,
                remaining,
                progress: Math.min(100, Math.round((referralsCount / config.referralsRequired) * 100)),
                eligible: referralsCount >= config.referralsRequired,
                claimed: req.user.rewardClaimed,
            };
        }

        res.status(200).json({
            success: true,
            count: referrals.length,
            referralsCount,
            rewardStatus,
            data: referrals,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Get reward eligibility status for logged-in user
// @route   GET /api/referrals/reward-status
// @access  Private
exports.getRewardStatus = async (req, res, next) => {
    try {
        const grade = req.user.grade;
        const config = REWARD_CONFIG[grade];

        if (!config) {
            return res.status(400).json({
                success: false,
                message: 'No reward program found for your grade. Please update your grade in your profile.',
            });
        }

        const referralsCount = req.user.referralsCount || 0;
        const remaining = Math.max(0, config.referralsRequired - referralsCount);

        res.status(200).json({
            success: true,
            data: {
                grade,
                reward: config.reward,
                rewardLabel: config.rewardLabel,
                description: config.description,
                referralsRequired: config.referralsRequired,
                referralsCount,
                remaining,
                progress: Math.min(100, Math.round((referralsCount / config.referralsRequired) * 100)),
                eligible: referralsCount >= config.referralsRequired,
                claimed: req.user.rewardClaimed,
            },
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Claim reward once eligible
// @route   POST /api/referrals/claim-reward
// @access  Private
exports.claimReward = async (req, res, next) => {
    try {
        const grade = req.user.grade;
        const config = REWARD_CONFIG[grade];

        if (!config) {
            return res.status(400).json({ success: false, message: 'No reward program found for your grade.' });
        }

        if (req.user.rewardClaimed) {
            return res.status(400).json({ success: false, message: 'You have already claimed your reward.' });
        }

        const referralsCount = req.user.referralsCount || 0;
        if (referralsCount < config.referralsRequired) {
            return res.status(400).json({
                success: false,
                message: `You need ${config.referralsRequired - referralsCount} more referral(s) to claim your reward.`,
            });
        }

        await User.findByIdAndUpdate(req.user.id, { rewardClaimed: true });

        res.status(200).json({
            success: true,
            message: `Congratulations! Your "${config.rewardLabel}" reward has been claimed. Our team will process it within 3-5 business days.`,
            reward: config.reward,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Verify referral code (public)
// @route   POST /api/referrals/verify
// @access  Public
exports.verifyReferralCode = async (req, res, next) => {
    try {
        const { referralCode } = req.body;

        const user = await User.findOne({ referralCode });

        if (!user) {
            return res.status(404).json({ success: false, message: 'Invalid Referral Code' });
        }

        res.status(200).json({
            success: true,
            referrerName: user.name,
        });
    } catch (error) {
        next(error);
    }
};
