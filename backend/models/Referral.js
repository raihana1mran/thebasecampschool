const mongoose = require('mongoose');

const ReferralSchema = new mongoose.Schema({
    referrerId: {
        type: mongoose.Schema.ObjectId,
        ref: 'User',
        required: true,
    },
    referredUserId: {
        type: mongoose.Schema.ObjectId,
        ref: 'User',
        required: true,
    },
    status: {
        type: String,
        enum: ['Pending', 'Successful'],
        default: 'Pending',
    },
}, {
    timestamps: true,
});

module.exports = mongoose.model('Referral', ReferralSchema);
