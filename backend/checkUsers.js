const mongoose = require('mongoose');
const dotenv = require('dotenv');
const User = require('./models/User');

dotenv.config();

const checkUsers = async () => {
    try {
        await mongoose.connect(process.env.MONGO_URI);
        const users = await User.find({}).select('+password');
        console.log("Total users in DB:", users.length);
        users.forEach(u => {
            console.log(`- Email: ${u.email} | Role: ${u.role} | Hash: ${u.password.substring(0, 15)}...`);
        });
        process.exit(0);
    } catch (error) {
        console.error('Error fetching users:', error);
        process.exit(1);
    }
};

checkUsers();
