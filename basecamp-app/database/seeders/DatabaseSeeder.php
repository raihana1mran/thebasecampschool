<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin
        $admin = User::firstOrCreate([
            'email' => 'admin@basecamp.com',
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('password'), // or Hash::make
            'role' => 'admin',
        ]);

        // Default Student
        $student = User::firstOrCreate([
            'email' => 'student@basecamp.com',
        ], [
            'name' => 'Test Student',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        // Demo Product
        \App\Models\Product::firstOrCreate([
            'title' => 'Biology Revision Notes',
        ], [
            'price' => 299,
            'category' => 'pdf',
            'description' => 'Complete biology syllabus revision notes for Class 10.',
            'file_urls' => json_encode(['https://example.com/dummy.pdf']),
        ]);

        // Demo Mock Tests
        \App\Models\MockTest::firstOrCreate([
            'title' => 'Complete Physics Test',
        ], [
            'type' => 'Full Syllabus',
            'duration' => 10,
            'subject' => 'Physics (312)',
            'class_standard' => '12th',
            'questions' => [
                [
                    'questionText' => 'What is the speed of light in vacuum?',
                    'options' => ['3x10^8 m/s', '3x10^5 m/s', '3x10^6 m/s', '3x10^7 m/s'],
                    'correctAnswer' => '3x10^8 m/s',
                    'explanation' => 'Speed of light is constant in vacuum, denoted by c, approximately 3x10^8 meters per second.'
                ],
                [
                    'questionText' => 'Which of the following is the SI unit of electric charge?',
                    'options' => ['Volt', 'Coulomb', 'Ampere', 'Ohm'],
                    'correctAnswer' => 'Coulomb',
                    'explanation' => 'The Coulomb (C) is the standard SI unit of electric charge.'
                ]
            ],
            'created_by' => $admin->id
        ]);

        \App\Models\MockTest::firstOrCreate([
            'title' => 'Biology Cell structure and functions',
        ], [
            'type' => 'Chapter-wise',
            'duration' => 15,
            'subject' => 'Biology (314)',
            'class_standard' => '12th',
            'questions' => [
                [
                    'questionText' => 'Which organelle is known as the powerhouse of the cell?',
                    'options' => ['Nucleus', 'Mitochondria', 'Ribosome', 'Golgi apparatus'],
                    'correctAnswer' => 'Mitochondria',
                    'explanation' => 'Mitochondria generate most of the cell\'s supply of adenosine triphosphate (ATP), used as a source of chemical energy.'
                ],
                [
                    'questionText' => 'Which of the following is responsible for photosynthesis in plant cells?',
                    'options' => ['Chloroplast', 'Lysosome', 'Centrosome', 'Cell Wall'],
                    'correctAnswer' => 'Chloroplast',
                    'explanation' => 'Chloroplasts conduct photosynthesis, where the photosynthetic pigment chlorophyll captures the energy from sunlight.'
                ]
            ],
            'created_by' => $admin->id
        ]);

        \App\Models\MockTest::firstOrCreate([
            'title' => 'Chemical Reactions & Equations',
        ], [
            'type' => 'Chapter-wise',
            'duration' => 10,
            'subject' => 'Science & Technology (212)',
            'class_standard' => '10th',
            'questions' => [
                [
                    'questionText' => 'What type of reaction occurs when iron rusts?',
                    'options' => ['Reduction', 'Oxidation', 'Displacement', 'Double displacement'],
                    'correctAnswer' => 'Oxidation',
                    'explanation' => 'Rusting of iron is an oxidation reaction where iron reacts with oxygen in the presence of moisture.'
                ],
                [
                    'questionText' => 'Which gas is produced when zinc reacts with dilute hydrochloric acid?',
                    'options' => ['Oxygen', 'Hydrogen', 'Carbon Dioxide', 'Nitrogen'],
                    'correctAnswer' => 'Hydrogen',
                    'explanation' => 'Metal + Acid -> Salt + Hydrogen gas. Zinc reacts with HCl to produce Zinc chloride and Hydrogen gas.'
                ]
            ],
            'created_by' => $admin->id
        ]);

        \App\Models\MockTest::firstOrCreate([
            'title' => '10th Grade Mathematics Practice Test',
        ], [
            'type' => 'Full Syllabus',
            'duration' => 20,
            'subject' => 'Mathematics (211)',
            'class_standard' => '10th',
            'questions' => [
                [
                    'questionText' => 'What is the sum of the first 10 natural numbers?',
                    'options' => ['45', '55', '65', '50'],
                    'correctAnswer' => '55',
                    'explanation' => 'Sum = n(n+1)/2 = 10(11)/2 = 55.'
                ],
                [
                    'questionText' => 'If quadratic equation x^2 - 5x + 6 = 0 has roots p and q, what is the value of p + q?',
                    'options' => ['5', '-5', '6', '-6'],
                    'correctAnswer' => '5',
                    'explanation' => 'Sum of roots of ax^2 + bx + c = 0 is -b/a. Here, -(-5)/1 = 5.'
                ]
            ],
            'created_by' => $admin->id
        ]);

        // Demo Admission
        \App\Models\Admission::firstOrCreate([
            'user_id' => $student->id,
            'course_type' => 'Secondary',
        ], [
            'full_name' => 'Test Student',
            'email' => 'student@basecamp.com',
            'mobile_number' => '1234567890',
            'date_of_birth' => '2005-01-01',
            'status' => 'Pending'
        ]);

        // Seeding Biology Video Lesson
        \App\Models\VideoLesson::firstOrCreate([
            'subject' => 'Biology (314)',
            'class_level' => 'Senior Secondary (12th)',
        ], [
            'playlist_url' => 'https://www.youtube.com/playlist?list=PLJtCpape_TuiytvOVnvffWeWFSimU5aiT',
        ]);
    }
}
