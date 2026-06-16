const express = require('express');
const {
    getMockTests,
    getMockTest,
    createMockTest,
    submitMockTest,
    deleteMockTest,
} = require('../controllers/mockTestController');
const { protect, authorize } = require('../middlewares/auth');

const router = express.Router();

router
    .route('/')
    .get(protect, getMockTests)
    .post(protect, authorize('admin'), createMockTest);

router
    .route('/:id')
    .get(protect, getMockTest)
    .delete(protect, authorize('admin'), deleteMockTest);
router.route('/:id/submit').post(protect, submitMockTest);

module.exports = router;
