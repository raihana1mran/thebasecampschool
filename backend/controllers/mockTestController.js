const MockTest = require('../models/MockTest');

// @desc    Get all mock tests
// @route   GET /api/mocktests
// @access  Private (Student/Admin)
exports.getMockTests = async (req, res, next) => {
    try {
        const mockTests = await MockTest.find().select('-questions.correctAnswer -questions.explanation');

        res.status(200).json({
            success: true,
            count: mockTests.length,
            data: mockTests,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Get single mock test (with or without answers based on role/submission context)
// @route   GET /api/mocktests/:id
// @access  Private
exports.getMockTest = async (req, res, next) => {
    try {
        let test = await MockTest.findById(req.params.id);

        if (!test) {
            return res.status(404).json({ success: false, message: 'Mock test not found' });
        }

        // Hide answers if strictly taking the test (to be refined based on application logic)
        // For now, return the full test if admin, else omit answers
        if (req.user.role !== 'admin') {
            test = await MockTest.findById(req.params.id).select('-questions.correctAnswer -questions.explanation');
        }

        res.status(200).json({
            success: true,
            data: test,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Create new mock test
// @route   POST /api/mocktests
// @access  Private (Admin)
exports.createMockTest = async (req, res, next) => {
    try {
        req.body.createdBy = req.user.id;

        const test = await MockTest.create(req.body);

        res.status(201).json({
            success: true,
            data: test,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Submit mock test (Evaluate answers)
// @route   POST /api/mocktests/:id/submit
// @access  Private (Student)
exports.submitMockTest = async (req, res, next) => {
    try {
        const test = await MockTest.findById(req.params.id);

        if (!test) {
            return res.status(404).json({ success: false, message: 'Mock test not found' });
        }

        const { answers } = req.body; // Array of selected answers matching question IDs/Index
        let score = 0;
        const results = [];

        test.questions.forEach((q, index) => {
            const isCorrect = answers[index] === q.correctAnswer;
            if (isCorrect) score += 1;

            results.push({
                questionId: q._id,
                selectedAnswer: answers[index],
                correctAnswer: q.correctAnswer,
                explanation: q.explanation,
                isCorrect,
            });
        });

        res.status(200).json({
            success: true,
            score,
            total: test.questions.length,
            results,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Delete single mock test
// @route   DELETE /api/mocktests/:id
// @access  Private (Admin)
exports.deleteMockTest = async (req, res, next) => {
    try {
        const test = await MockTest.findById(req.params.id);

        if (!test) {
            return res.status(404).json({ success: false, message: 'Mock test not found' });
        }

        await MockTest.deleteOne({ _id: req.params.id });

        res.status(200).json({
            success: true,
            data: {},
            message: 'Mock test deleted successfully'
        });
    } catch (error) {
        next(error);
    }
};
