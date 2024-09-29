<?php
namespace Database\Factories;

use App\Models\Catigory; // Adjust this to match your actual Category model name
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CatigoryFactory extends Factory
{
    protected $model = Catigory::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'slug' => Str::slug($this->faker->unique()->word),
        ];
    }
}
