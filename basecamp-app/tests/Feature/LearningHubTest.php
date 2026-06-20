<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearningHubTest extends TestCase
{
    use RefreshDatabase;

    public function test_learning_hub_page_loads_successfully_for_12th_student(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
            'enrollment_number' => 'TBC-2026-TEST',
        ]);

        Admission::create([
            'user_id' => $student->id,
            'course_type' => 'senior secondary',
            'full_name' => $student->name,
            'father_name' => 'Father',
            'mother_name' => 'Mother',
            'gender' => 'Male',
            'date_of_birth' => '2008-01-01',
            'aadhaar_number' => '123456789012',
            'address' => 'Address',
            'previous_qualification' => 'Class 11',
            'mobile_number' => '9876543210',
            'email' => $student->email,
            'reference_number' => 'REF-DASH-TEST',
            'status' => 'Approved',
        ]);

        $response = $this->actingAs($student)->get('/learning');

        $response->assertStatus(200);
    }

    public function test_learning_hub_page_loads_successfully_for_10th_student(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
            'enrollment_number' => 'TBC-2026-TEST2',
        ]);

        Admission::create([
            'user_id' => $student->id,
            'course_type' => 'secondary',
            'full_name' => $student->name,
            'father_name' => 'Father',
            'mother_name' => 'Mother',
            'gender' => 'Male',
            'date_of_birth' => '2008-01-01',
            'aadhaar_number' => '123456789012',
            'address' => 'Address',
            'previous_qualification' => 'Class 9',
            'mobile_number' => '9876543211',
            'email' => $student->email,
            'reference_number' => 'REF-DASH-TEST2',
            'status' => 'Approved',
        ]);

        $response = $this->actingAs($student)->get('/learning');

        $response->assertStatus(200);
    }
}
