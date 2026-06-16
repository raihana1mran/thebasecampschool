const mongoose = require('mongoose');
const dotenv = require('dotenv');
const User = require('./models/User');

// Load env vars
dotenv.config();

const seedAdmin = async () => {
    try {
        await mongoose.connect(process.env.MONGO_URI);

        console.log('MongoDB Connected...');

        // Check if admin already exists
        const existingAdmin = await User.findOne({ email: 'admin@basecamp.com' });

        if (existingAdmin) {
            console.log('Admin user already exists!');
            process.exit(0);
        }

        // Create new admin user
        const admin = await User.create({
            name: 'System Admin',
            email: 'admin@basecamp.com',
            password: 'password123', // Will be hashed by the User model's pre-save hook
            role: 'admin',
        });

        console.log(`Admin user created successfully!`);
        console.log(`Email: ${admin.email}`);
        console.log(`Password: password123`);

        process.exit(0);
    } catch (error) {
        console.error('Error seeding admin:', error);
        process.exit(1);
    }
};

seedAdmin();
