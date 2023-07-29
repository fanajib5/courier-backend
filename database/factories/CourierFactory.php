<?php

// ~\courier-backend\database\factories\CourierFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courier>
 */
class CourierFactory extends Factory
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
            'DOB' => fake()->dateTimeBetween('1989-01-01', '1998-12-31'),
            'created_at' => now(),
            'phone' => fake('id_ID')->e164PhoneNumber(),
            'status' => fake()->randomElement(['Active', 'Disabled']),
            'DOJ' => fake()->dateTimeBetween('2019-01-01', '2023-03-20'),
            'level' => fake()->numberBetween(1,5),
            'branch_id' => fake()->numberBetween(1,25),
        ];
    }
}
