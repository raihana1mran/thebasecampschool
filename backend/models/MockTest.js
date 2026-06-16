const mongoose = require('mongoose');

const QuestionSchema = new mongoose.Schema({
    questionText: String,
    options: [String],
    correctAnswer: String,
    explanation: String,
});

const MockTestSchema = new mongoose.Schema({
    title: {
        type: String,
        required: [true, 'Please add a test title'],
    },
    type: {
        type: String,
        enum: ['Chapter-wise', 'Full Syllabus'],
        default: 'Chapter-wise',
    },
    questions: [QuestionSchema],
    duration: {
        type: Number, // in minutes
        required: true,
    },
    createdBy: {
        type: mongoose.Schema.ObjectId,
        ref: 'User',
        required: true,
    },
}, {
    timestamps: true,
});

module.exports = mongoose.model('MockTest', MockTestSchema);
