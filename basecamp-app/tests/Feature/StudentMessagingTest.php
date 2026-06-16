<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admission;
use App\Models\BroadcastMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentMessagingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_send_personalized_message_to_student(): void
    {
        // Create admin
        $admin = User::factory()->create([
            'role' => 'admin',
            'enrollment_number' => 'TBC-2026-ADMIN',
        ]);

        // Create student
        $student = User::factory()->create([
            'role' => 'student',
            'enrollment_number' => 'TBC-2026-STUDENT',
        ]);

        $response = $this->actingAs($admin)->post('/admin/message', [
            'audience' => $student->email,
            'subject' => 'Personal Subject',
            'message' => 'Hello student, this is a personalized message.',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('broadcast_messages', [
            'audience' => $student->email,
            'subject' => 'Personal Subject',
            'message' => 'Hello student, this is a personalized message.',
        ]);
    }

    public function test_student_sees_personalized_message_on_dashboard(): void
    {
        // Create student A
        $studentA = User::factory()->create([
            'role' => 'student',
            'email' => 'studenta@example.com',
            'enrollment_number' => 'TBC-2026-STUDA',
        ]);

        // Create student B
        $studentB = User::factory()->create([
            'role' => 'student',
            'email' => 'studentb@example.com',
            'enrollment_number' => 'TBC-2026-STUDB',
        ]);

        // Create admission records for both so they get dashboard context
        Admission::create([
            'user_id' => $studentA->id,
            'course_type' => '10th',
            'full_name' => $studentA->name,
            'father_name' => 'Father',
            'mother_name' => 'Mother',
            'gender' => 'Male',
            'date_of_birth' => '2010-01-01',
            'aadhaar_number' => '123456789012',
            'address' => 'Address A',
            'previous_qualification' => 'Class 9',
            'mobile_number' => '9876543210',
            'email' => $studentA->email,
            'reference_number' => 'REF-A',
            'status' => 'Approved',
        ]);

        Admission::create([
            'user_id' => $studentB->id,
            'course_type' => '12th',
            'full_name' => $studentB->name,
            'father_name' => 'Father',
            'mother_name' => 'Mother',
            'gender' => 'Male',
            'date_of_birth' => '2008-01-01',
            'aadhaar_number' => '123456789013',
            'address' => 'Address B',
            'previous_qualification' => 'Class 10',
            'mobile_number' => '9876543211',
            'email' => $studentB->email,
            'reference_number' => 'REF-B',
            'status' => 'Approved',
        ]);

        // Create a broadcast for student A
        BroadcastMessage::create([
            'audience' => $studentA->email,
            'subject' => 'Notice For Student A Only',
            'message' => 'Secret message for student A.',
        ]);

        // Create a broadcast for student B
        BroadcastMessage::create([
            'audience' => $studentB->email,
            'subject' => 'Notice For Student B Only',
            'message' => 'Secret message for student B.',
        ]);

        // Access dashboard as student A
        $responseA = $this->actingAs($studentA)->get('/dashboard');
        $responseA->assertStatus(200);
        $responseA->assertSee('Notice For Student A Only');
        $responseA->assertSee('Secret message for student A.');
        $responseA->assertDontSee('Notice For Student B Only');
        $responseA->assertDontSee('Secret message for student B.');

        // Access dashboard as student B
        $responseB = $this->actingAs($studentB)->get('/dashboard');
        $responseB->assertStatus(200);
        $responseB->assertSee('Notice For Student B Only');
        $responseB->assertSee('Secret message for student B.');
        $responseB->assertDontSee('Notice For Student A Only');
        $responseB->assertDontSee('Secret message for student A.');
    }
}
