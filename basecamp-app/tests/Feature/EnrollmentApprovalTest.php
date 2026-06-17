<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnrollmentCredentials;
use Tests\TestCase;

class EnrollmentApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_approving_student_creates_credentials_and_sends_email(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'student', 'enrollment_number' => null]);

        $admission = Admission::create([
            'user_id' => $student->id,
            'course_type' => '12th',
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
            'reference_number' => 'REF-APPROVAL-TEST',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($admin)->put("/admin/admissions/{$admission->id}/status", [
            'status' => 'Approved',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'credentials' => ['enrollment_number', 'password'],
        ]);

        $student->refresh();
        $this->assertNotNull($student->enrollment_number);
        $this->assertNull($student->first_login_at);

        Mail::assertSent(EnrollmentCredentials::class, function ($mail) use ($student) {
            return $mail->hasTo($student->email) && $mail->user->id === $student->id;
        });
    }

    public function test_unapproved_student_redirected_to_onboarding(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
            'enrollment_number' => null,
        ]);

        $response = $this->actingAs($student)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Admission Status');
    }

    public function test_approved_student_with_enrollment_sees_dashboard(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
            'enrollment_number' => 'TBC-2026-TEST',
        ]);

        Admission::create([
            'user_id' => $student->id,
            'course_type' => '12th',
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

        $response = $this->actingAs($student)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Welcome back');

        $student->refresh();
        $this->assertNotNull($student->first_login_at);
    }

    public function test_student_with_enrollment_but_pending_status_sees_onboarding(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
            'enrollment_number' => 'TBC-2026-PENDING',
        ]);

        Admission::create([
            'user_id' => $student->id,
            'course_type' => '12th',
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
            'reference_number' => 'REF-PEND-TEST',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($student)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Admission Status');
    }
}
