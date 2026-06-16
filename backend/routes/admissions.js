const express = require('express');
const {
    submitAdmission,
    getMyAdmissions,
    getAdmissions,
    updateAdmissionStatus,
} = require('../controllers/admissionController');
const { protect, authorize } = require('../middlewares/auth');
const upload = require('../middlewares/upload');

const router = express.Router();

router
    .route('/')
    .post(
        protect,
        upload.fields([
            { name: 'photo', maxCount: 1 },
            { name: 'signature', maxCount: 1 },
            { name: 'idProof', maxCount: 1 },
            { name: 'previousMarksheet', maxCount: 1 },
        ]),
        submitAdmission
    )
    .get(protect, authorize('admin'), getAdmissions);

router.route('/me').get(protect, getMyAdmissions);

router
    .route('/:id/status')
    .put(protect, authorize('admin'), updateAdmissionStatus);

module.exports = router;
