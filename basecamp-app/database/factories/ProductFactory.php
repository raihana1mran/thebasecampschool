<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 0, 500),
            'category' => fake()->randomElement(['pdf', 'tma', 'Class 12th', 'Class 10th', 'Competitive', 'General']),
            'file_urls' => [fake()->word() . '.pdf'],
            'preview_url' => null,
            'download_limit' => 3,
        ];
    }
}
