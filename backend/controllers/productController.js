const Product = require('../models/Product');

// @desc    Get all products
// @route   GET /api/products
// @access  Public
exports.getProducts = async (req, res, next) => {
    try {
        const products = await Product.find();

        res.status(200).json({
            success: true,
            count: products.length,
            data: products,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Get single product
// @route   GET /api/products/:id
// @access  Public
exports.getProduct = async (req, res, next) => {
    try {
        const product = await Product.findById(req.params.id);

        if (!product) {
            return res.status(404).json({ success: false, message: 'Product not found' });
        }

        res.status(200).json({
            success: true,
            data: product,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Create new product
// @route   POST /api/products
// @access  Private (Admin)
exports.createProduct = async (req, res, next) => {
    try {
        // Handle multiple file uploads for product material and a preview image
        const fileURLs = req.files && req.files['files'] ? req.files['files'].map(f => f.path) : [];
        const previewURL = req.files && req.files['preview'] ? req.files['preview'][0].path : '';

        const product = await Product.create({
            title: req.body.title,
            description: req.body.description,
            price: req.body.price,
            category: req.body.category,
            fileURLs,
            previewURL,
        });

        res.status(201).json({
            success: true,
            data: product,
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Delete single product
// @route   DELETE /api/products/:id
// @access  Private (Admin)
exports.deleteProduct = async (req, res, next) => {
    try {
        const product = await Product.findById(req.params.id);

        if (!product) {
            return res.status(404).json({ success: false, message: 'Product not found' });
        }

        await Product.deleteOne({ _id: req.params.id });

        res.status(200).json({
            success: true,
            data: {},
            message: 'Product deleted successfully'
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Unlock a product for a user (free or premium)
// @route   POST /api/products/:id/unlock
// @access  Private
exports.unlockProduct = async (req, res, next) => {
    try {
        const User = require('../models/User');
        const user = await User.findById(req.user.id);
        const product = await Product.findById(req.params.id);

        if (!product) {
            return res.status(404).json({ success: false, message: 'Product not found' });
        }

        const isAlreadyUnlocked = user.unlockedProducts.includes(product._id);

        if (isAlreadyUnlocked) {
            return res.status(200).json({ success: true, message: 'Product already unlocked', product });
        }

        if (user.membershipPlan === 'premium') {
            user.unlockedProducts.push(product._id);
            await user.save();
            return res.status(200).json({ success: true, message: 'Product unlocked successfully (Premium)', product });
        } else {
            if (user.unlockedProducts.length >= 5) {
                return res.status(403).json({ success: false, message: 'Free plan limit reached (5 materials). Please upgrade to Premium.' });
            }
            user.unlockedProducts.push(product._id);
            await user.save();
            return res.status(200).json({ success: true, message: 'Product unlocked successfully (Free plan)', product });
        }
    } catch (error) {
        next(error);
    }
};
