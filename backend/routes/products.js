const express = require('express');
const {
    getProducts,
    getProduct,
    createProduct,
    deleteProduct,
    unlockProduct,
} = require('../controllers/productController');
const { protect, authorize } = require('../middlewares/auth');
const upload = require('../middlewares/upload');

const router = express.Router();

router
    .route('/')
    .get(getProducts)
    .post(
        protect,
        authorize('admin'),
        upload.fields([
            { name: 'files', maxCount: 10 },
            { name: 'preview', maxCount: 1 },
        ]),
        createProduct
    );

router.post('/:id/unlock', protect, unlockProduct);

router
    .route('/:id')
    .get(getProduct)
    .delete(protect, authorize('admin'), deleteProduct);

module.exports = router;
