<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUsers extends Command
{
    protected $signature = 'make:test-users';
    protected $description = 'Create test student and admin users';

    public function handle()
    {
        // Check if role column has values - try both 'admin' and 'student'
        
        // Try creating with 'admin' role first
        $admin = User::firstOrNew(['email' => 'admin@test.com']);
        if (!$admin->exists) {
            $admin->name = 'Admin User';
            $admin->password = Hash::make('password123');
            $admin->role = 'admin';
            $admin->email_verified_at = now();
            $admin->save();
            $this->info('Admin user created: admin@test.com / password123');
        } else {
            // Update to admin
            $admin->role = 'admin';
            $admin->save();
            $this->info('Admin user updated: admin@test.com / password123');
        }

        // Try creating with 'student' role
        $student = User::firstOrNew(['email' => 'student@test.com']);
        if (!$student->exists) {
            $student->name = 'Test Student';
            $student->password = Hash::make('password123');
            $student->role = 'student';
            $student->email_verified_at = now();
            $student->save();
            $this->info('Student user created: student@test.com / password123');
        } else {
            $student->role = 'student';
            $student->save();
            $this->info('Student user updated: student@test.com / password123');
        }

        $this->info('All test users ready!');
    }
}