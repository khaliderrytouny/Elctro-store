<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty = $this->faker->numberBetween(1, 10);
        $price = $this->faker->randomFloat(2, 10, 100);
        $total = $qty * $price;

        return [
            'user_id' => User::factory(), // Assuming User factory exists
            'product_name' => $this->faker->word(),
            'qty' => $qty,
            'price' => $price,
            'total' => $total,
            'paid' => $this->faker->boolean(),
            'delivered' => $this->faker->boolean(),
        ];
    }
}
