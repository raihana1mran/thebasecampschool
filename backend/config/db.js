const mongoose = require('mongoose');
const { MongoMemoryServer } = require('mongodb-memory-server');

const connectDB = async () => {
    try {
        const mongoServer = await MongoMemoryServer.create();
        const mongoUri = mongoServer.getUri();

        const conn = await mongoose.connect(mongoUri);

        console.log(`MongoDB Connected (In-Memory): ${conn.connection.host}`);

        // Automatically seed the admin user on startup
        const User = require('../models/User');
        const adminExists = await User.findOne({ role: 'admin' });
        if (!adminExists) {
            await User.create({
                name: 'System Admin',
                email: 'admin@basecamp.com',
                password: 'password123',
                role: 'admin',
                referralCode: 'ADMINREF123',
                isVerified: true
            });
            console.log('Seeded initial admin user: admin@basecamp.com / password123');
        }

    } catch (error) {
        console.error(`Error: ${error.message}`);
        process.exit(1);
    }
};

module.exports = connectDB;
