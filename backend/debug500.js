const jwt = require('jsonwebtoken');
const mongoose = require('mongoose');
const dotenv = require('dotenv');
dotenv.config();

const testUser = async () => {
    try {
        const connectDB = require('./config/db');
        await connectDB();
        const User = require('./models/User');

        // 1. Create a dummy token 
        const dummyToken = jwt.sign({ id: new mongoose.Types.ObjectId() }, process.env.JWT_SECRET, { expiresIn: '1d' });

        console.log("Token created:", dummyToken);

        // 2. Simulate auth.js logic
        const decoded = jwt.verify(dummyToken, process.env.JWT_SECRET);
        console.log("Token decoded:", decoded);

        const user = await User.findById(decoded.id);
        console.log("User found:", user); // Should be null!

        if (!user) {
            console.log("Simulating 401: User no longer exists");
            process.exit(0);
        }

    } catch (e) {
        console.error("Simulation crashed with error:", e);
    }
    process.exit(1);
}

testUser();
