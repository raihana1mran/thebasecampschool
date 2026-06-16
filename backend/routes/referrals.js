const express = require('express');
const {
    getMyReferrals,
    getRewardStatus,
    claimReward,
    verifyReferralCode,
} = require('../controllers/referralController');
const { protect } = require('../middlewares/auth');

const router = express.Router();

router.get('/me', protect, getMyReferrals);
router.get('/reward-status', protect, getRewardStatus);
router.post('/claim-reward', protect, claimReward);
router.post('/verify', verifyReferralCode);

module.exports = router;
