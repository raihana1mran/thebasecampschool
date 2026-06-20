<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\BroadcastMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBroadcastTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_broadcast_message(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $broadcast = BroadcastMessage::create([
            'audience' => 'all',
            'subject'  => 'Test Announcement',
            'message'  => 'This is a test notification.',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/broadcasts/{$broadcast->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Broadcast message deleted successfully.',
        ]);

        $this->assertDatabaseMissing('broadcast_messages', [
            'id' => $broadcast->id,
        ]);
    }

    public function test_non_admin_cannot_delete_broadcast_message(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $broadcast = BroadcastMessage::create([
            'audience' => 'all',
            'subject'  => 'Test Announcement',
            'message'  => 'This is a test notification.',
        ]);

        $response = $this->actingAs($student)->delete("/admin/broadcasts/{$broadcast->id}");

        $response->assertStatus(403); // Or redirect, depending on EnsureIsAdmin middleware
        $this->assertDatabaseHas('broadcast_messages', [
            'id' => $broadcast->id,
        ]);
    }
}
