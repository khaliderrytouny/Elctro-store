<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => "admin",
            'email' => "admin@admin.com",
            'email_verified_at' => now(),
            'password' => Hash::make("admin"), // Hash the password
            'remember_token' => Str::random(10),
        ];
    }
}
