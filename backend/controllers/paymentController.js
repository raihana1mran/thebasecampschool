const Payment = require('../models/Payment');
const User = require('../models/User');
const Referral = require('../models/Referral');

// @desc    Create a mock order (Razorpay removed)
// @route   POST /api/payments/order
// @access  Private
exports.createOrder = async (req, res, next) => {
    try {
        const { amount, type } = req.body;

        return res.status(200).json({
            success: true,
            order: {
                id: `mock_order_${Math.floor(Math.random() * 1000000)}`,
                amount: amount * 100,
                currency: 'INR'
            },
        });

    } catch (error) {
        next(error);
    }
};

// @desc    Verify mock payment (Razorpay removed)
// @route   POST /api/payments/verify
// @access  Private
exports.verifyPayment = async (req, res, next) => {
    try {
        const { razorpay_order_id, razorpay_payment_id, type, amount } = req.body;

        const payment = await Payment.create({
            userId: req.user.id,
            amount,
            paymentId: razorpay_payment_id || `mock_pay_${Math.floor(Math.random() * 1000000)}`,
            type,
            status: 'Success',
        });

        if (type === 'Admission') {
            const user = await User.findById(req.user.id);
            if (user.referredBy) {
                const referral = await Referral.findOne({ referredUserId: user._id });
                if (referral) {
                    referral.status = 'Successful';
                    await referral.save();

                    const referrer = await User.findById(user.referredBy);
                    referrer.referralsCount += 1;
                    await referrer.save();
                }
            }
        } else if (type === 'Membership') {
            const user = await User.findById(req.user.id);
            user.membershipPlan = 'premium';
            await user.save();
        }

        return res.status(200).json({ success: true, message: 'Mock payment verified successfully', payment });

    } catch (error) {
        next(error);
    }
};

// @desc    Get user's payments
// @route   GET /api/payments/me
// @access  Private
exports.getMyPayments = async (req, res, next) => {
    try {
        const payments = await Payment.find({ userId: req.user.id });
        res.status(200).json({
            success: true,
            count: payments.length,
            data: payments,
        });
    } catch (error) {
        next(error);
    }
};
