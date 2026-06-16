const mongoose = require('mongoose');

const AdmissionSchema = new mongoose.Schema({
    userId: {
        type: mongoose.Schema.ObjectId,
        ref: 'User',
        required: true,
    },
    courseType: {
        type: String,
        enum: ['10th', '12th'],
        required: true,
    },
    status: {
        type: String,
        enum: ['Pending', 'Approved', 'Rejected'],
        default: 'Pending',
    },
    fullName: String,
    fatherName: String,
    motherName: String,
    gender: String,
    dateOfBirth: Date,
    aadhaarNumber: String,
    address: String,
    previousQualification: String,
    mobileNumber: String,
    email: String,
    documents: {
        photo: String,
        signature: String,
        idProof: String,
        previousMarksheet: String,
    },
    paymentId: {
        type: mongoose.Schema.ObjectId,
        ref: 'Payment',
    },
}, {
    timestamps: true,
});

module.exports = mongoose.model('Admission', AdmissionSchema);
