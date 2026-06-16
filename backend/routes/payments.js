const express = require('express');
const {
    createOrder,
    verifyPayment,
    getMyPayments,
} = require('../controllers/paymentController');
const { protect } = require('../middlewares/auth');

const router = express.Router();

router.post('/order', protect, createOrder);
router.post('/verify', protect, verifyPayment);
router.get('/me', protect, getMyPayments);

module.exports = router;
