<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownloadsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_downloads_page_shows_products()
    {
        $user = User::factory()->create([
            'role' => 'student',
            'enrollment_number' => 'TBC-TEST-001',
            'unlocked_products' => [],
        ]);

        $product = Product::factory()->create([
            'title' => 'Test Free Resource',
            'price' => 0,
            'category' => 'pdf',
            'file_urls' => ['files/test.pdf'],
        ]);

        $response = $this->actingAs($user)->get('/downloads');

        $response->assertStatus(200);
        $response->assertSee('Test Free Resource');
        $response->assertSee('Download');
    }

    public function test_downloads_page_shows_paid_product_with_unlock_button()
    {
        $user = User::factory()->create([
            'role' => 'student',
            'enrollment_number' => 'TBC-TEST-002',
            'unlocked_products' => [],
        ]);

        $product = Product::factory()->create([
            'title' => 'Test Paid Resource',
            'price' => 100,
            'category' => 'pdf',
            'file_urls' => ['files/paid.pdf'],
        ]);

        $response = $this->actingAs($user)->get('/downloads');

        $response->assertStatus(200);
        $response->assertSee('Test Paid Resource');
        $response->assertSee('Unlock for');
        $response->assertSee('₹100');
        $response->assertDontSee('Download');
    }

    public function test_downloads_page_shows_download_for_unlocked_paid_product()
    {
        $user = User::factory()->create([
            'role' => 'student',
            'enrollment_number' => 'TBC-TEST-003',
            'unlocked_products' => [1],
        ]);

        $product = Product::factory()->create([
            'title' => 'Test Unlocked Paid Resource',
            'price' => 100,
            'category' => 'pdf',
            'file_urls' => ['files/paid.pdf'],
        ]);

        $response = $this->actingAs($user)->get('/downloads');

        $response->assertStatus(200);
        $response->assertSee('Test Unlocked Paid Resource');
        $response->assertSee('Download');
        $response->assertDontSee('Unlock for');
    }

    public function test_unlock_product_web_route()
    {
        $user = User::factory()->create([
            'role' => 'student',
            'enrollment_number' => 'TBC-TEST-004',
            'unlocked_products' => [],
        ]);

        $product = Product::factory()->create([
            'title' => 'Test Locked Resource',
            'price' => 50,
            'category' => 'pdf',
            'file_urls' => ['files/locked.pdf'],
        ]);

        $response = $this->actingAs($user)->post("/products/{$product->id}/unlock");

        $response->assertSessionHas('success');
        $response->assertRedirect();

        $user->refresh();
        $this->assertContains($product->id, $user->unlocked_products);
    }
}
