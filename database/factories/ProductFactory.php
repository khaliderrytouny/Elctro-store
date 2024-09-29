<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5), // Ensure unique slug
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'old_price' => $this->faker->randomFloat(2, 10, 100),
            'image' => $this->faker->imageUrl(640, 480, 'products'),
            'catigory_id' => \App\Models\Catigory::factory(), // Assuming Category factory exists
        ];
    }
}
