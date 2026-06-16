const mongoose = require('mongoose');

const ProductSchema = new mongoose.Schema({
    title: {
        type: String,
        required: [true, 'Please add a product title'],
    },
    description: {
        type: String,
        required: [true, 'Please add a description'],
    },
    price: {
        type: Number,
        required: [true, 'Please add a price'],
    },
    category: {
        type: String,
        default: 'other',
    },
    fileURLs: [{
        type: String,
        required: [true, 'Please add a secure file URL'],
    }],
    previewURL: {
        type: String,
    },
    downloadLimit: {
        type: Number,
        default: 3,
    },
}, {
    timestamps: true,
});

module.exports = mongoose.model('Product', ProductSchema);
