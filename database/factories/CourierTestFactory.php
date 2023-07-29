<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CourierTestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake('id_ID')->unique()->safeEmail(),
            'name' => fake('id_ID')->name(),
            'DOB' => fake()->date(),
            'created_at' => now(),
            'phone' => fake('id_ID')->phoneNumber(),
            'status' => fake()->randomElement(['Active', 'Disabled']),
            'DOJ' => fake()->date(),
            'level' => fake()->numberBetween(1,5),
            'branch_id' => fake()->numberBetween(1,25),
        ];
    }
}
