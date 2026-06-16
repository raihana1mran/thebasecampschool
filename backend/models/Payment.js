const mongoose = require('mongoose');

const PaymentSchema = new mongoose.Schema({
    userId: {
        type: mongoose.Schema.ObjectId,
        ref: 'User',
        required: true,
    },
    amount: {
        type: Number,
        required: true,
    },
    paymentId: {
        type: String, // Razorpay payment ID
        required: true,
    },
    status: {
        type: String,
        enum: ['Success', 'Failed', 'Pending'],
        default: 'Pending',
    },
    type: {
        type: String,
        enum: ['Admission', 'Product', 'Membership'],
        required: true,
    },
}, {
    timestamps: true,
});

module.exports = mongoose.model('Payment', PaymentSchema);
