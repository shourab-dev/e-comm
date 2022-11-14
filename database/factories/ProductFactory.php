<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\SubCategory;
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
    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'sub_category_id' => SubCategory::inRandomOrder()->first()->id,
            'title' => fake()->name(),
            'slug' => str()->slug(fake()->name()),
            'price' => fake()->numberBetween(100, 5000),
            'status' => true,
            'short_detail' => fake()->sentence(),
            'long_detail' => fake()->sentence(),
            'thumbnail_url' => fake()->imageUrl(640, 480, null, true, null, true),
        ];
    }
}
