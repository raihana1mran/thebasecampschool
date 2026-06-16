const Admission = require('../models/Admission');
const User = require('../models/User');

// @desc    Submit admission form
// @route   POST /api/admissions
// @access  Private (Student)
exports.submitAdmission = async (req, res, next) => {
    try {
        const {
            courseType,
            fullName,
            fatherName,
            motherName,
            gender,
            dateOfBirth,
            aadhaarNumber,
            address,
            previousQualification,
            mobileNumber,
            email,
        } = req.body;

        // Ensure user hasn't already submitted an admission that is pending or approved
        const existingAdmission = await Admission.findOne({
            userId: req.user.id,
            status: { $in: ['Pending', 'Approved'] },
        });

        if (existingAdmission) {
            return res.status(400).json({
                success: false,
                message: 'You already have a pending or approved admission application',
            });
        }

        // Handle document uploads (assuming URLs from Cloudinary/S3 via Multer middleware)
        const documents = {
            photo: req.files && req.files['photo'] ? req.files['photo'][0].path : '',
            signature: req.files && req.files['signature'] ? req.files['signature'][0].path : '',
            idProof: req.files && req.files['idProof'] ? req.files['idProof'][0].path : '',
            previousMarksheet: req.files && req.files['previousMarksheet'] ? req.files['previousMarksheet'][0].path : '',
        };

        const admission = await Admission.create({
            userId: req.user.id,
            courseType,
            fullName,
            fatherName,
            motherName,
            gender,
            dateOfBirth,
            aadhaarNumber,
            address,
            previousQualification,
            mobileNumber,
            email,
            documents,
        });

        res.status(201).json({
            success: true,
            data: admission,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Get current user's admissions
// @route   GET /api/admissions/me
// @access  Private (Student)
exports.getMyAdmissions = async (req, res, next) => {
    try {
        const admissions = await Admission.find({ userId: req.user.id });

        res.status(200).json({
            success: true,
            count: admissions.length,
            data: admissions,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Get all admissions (Admin)
// @route   GET /api/admissions
// @access  Private (Admin)
exports.getAdmissions = async (req, res, next) => {
    try {
        const admissions = await Admission.find().populate({
            path: 'userId',
            select: 'name email',
        });

        res.status(200).json({
            success: true,
            count: admissions.length,
            data: admissions,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Update admission status (Admin)
// @route   PUT /api/admissions/:id/status
// @access  Private (Admin)
exports.updateAdmissionStatus = async (req, res, next) => {
    try {
        let admission = await Admission.findById(req.params.id);

        if (!admission) {
            return res.status(404).json({ success: false, message: 'Admission not found' });
        }

        admission.status = req.body.status;
        await admission.save();

        res.status(200).json({
            success: true,
            data: admission,
        });
    } catch (error) {
        next(error);
    }
};
