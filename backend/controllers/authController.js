const User = require('../models/User');
const jwt = require('jsonwebtoken');

// Generate JWT
const generateToken = (id) => {
    return jwt.sign({ id }, process.env.JWT_SECRET, {
        expiresIn: process.env.JWT_EXPIRE,
    });
};

// @desc    Register user
// @route   POST /api/auth/register
// @access  Public
exports.register = async (req, res, next) => {
    try {
        const { name, email, password, role, grade, referralCode } = req.body;

        // Validate grade
        if (grade && ![10, 12].includes(Number(grade))) {
            return res.status(400).json({ success: false, message: 'Grade must be 10 or 12.' });
        }

        let user = await User.findOne({ email });

        if (user) {
            return res.status(400).json({ success: false, message: 'User already exists' });
        }

        // Logic for checking referral code
        let referredBy = null;
        let referrer = null;
        if (referralCode) {
            referrer = await User.findOne({ referralCode });
            if (referrer) {
                referredBy = referrer._id;
            }
        }

        // Generate custom referral code for the new user
        const newReferralCode = name.substring(0, 3).toUpperCase() + Math.random().toString(36).substring(2, 7).toUpperCase();

        user = await User.create({
            name,
            email,
            password,
            role,
            grade: grade ? Number(grade) : null,
            referralCode: newReferralCode,
            referredBy,
        });

        // Increment referrer's referralsCount now that the referred user exists
        if (referrer) {
            await User.findByIdAndUpdate(referrer._id, { $inc: { referralsCount: 1 } });
        }

        const token = generateToken(user._id);

        res.status(201).json({
            success: true,
            token,
            user: {
                id: user._id,
                name: user.name,
                email: user.email,
                role: user.role,
                grade: user.grade,
                referralCode: user.referralCode,
                referralsCount: user.referralsCount,
                rewardClaimed: user.rewardClaimed,
            }
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Login user
// @route   POST /api/auth/login
// @access  Public
exports.login = async (req, res, next) => {
    try {
        const { email, password } = req.body;

        if (!email || !password) {
            return res.status(400).json({ success: false, message: 'Please provide email and password' });
        }

        const normalizedEmail = email.toLowerCase().trim();
        const user = await User.findOne({ email: normalizedEmail }).select('+password');

        if (!user) {
            return res.status(401).json({ success: false, message: 'Invalid credentials' });
        }

        const isMatch = await user.matchPassword(password);

        if (!isMatch) {
            return res.status(401).json({ success: false, message: 'Invalid credentials' });
        }

        const token = generateToken(user._id);

        res.status(200).json({
            success: true,
            token,
            user: {
                id: user._id,
                name: user.name,
                email: user.email,
                role: user.role,
                grade: user.grade,
                referralCode: user.referralCode,
                referralsCount: user.referralsCount,
                rewardClaimed: user.rewardClaimed,
            }
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Get current logged in user
// @route   GET /api/auth/me
// @access  Private
exports.getMe = async (req, res, next) => {
    try {
        const user = await User.findById(req.user.id);
        res.status(200).json({
            success: true,
            data: user,
        });
    } catch (error) {
        next(error);
    }
};
