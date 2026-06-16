const express = require('express');
const { protect, authorize } = require('../middlewares/auth');
const User = require('../models/User');
const Admission = require('../models/Admission');

const router = express.Router();

// @desc    Get dashboard stats
// @route   GET /api/admin/stats
// @access  Private (Admin)
router.get('/stats', protect, authorize('admin'), async (req, res, next) => {
    try {
        const studentCount = await User.countDocuments({ role: 'student' });
        const pendingAdmissions = await Admission.countDocuments({ status: 'Pending' });

        res.status(200).json({
            success: true,
            data: {
                studentCount,
                pendingAdmissions,
            }
        });
    } catch (error) {
        next(error);
    }
});

// @desc    Get all students
// @route   GET /api/admin/students
// @access  Private (Admin)
router.get('/students', protect, authorize('admin'), async (req, res, next) => {
    try {
        const students = await User.find({ role: 'student' }).select('name email createdAt');
        res.status(200).json({ success: true, count: students.length, data: students });
    } catch (error) {
        next(error);
    }
});

// @desc    Message students
// @route   POST /api/admin/message
// @access  Private (Admin)
router.post('/message', protect, authorize('admin'), async (req, res, next) => {
    try {
        const { subject, message, audience } = req.body;
        // Mock email sending process
        res.status(200).json({ success: true, message: `Message broadcasted successfully to ${audience}` });
    } catch (error) {
        next(error);
    }
});

module.exports = router;
