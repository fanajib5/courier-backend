<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 *  //@extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $dobRange = fake()->dateTimeBetween('1989-01-01', '1998-12-31');
        $dojRange = fake()->dateTimeBetween('2019-01-01', '2023-03-20');

        return [
            'email' => fake('id_ID')->unique()->safeEmail(),
            'name' => fake('id_ID')->name(),
            'DOB' => date_format($dobRange, "Y-m-d"),
            'created_at' => now(),
            'phone' => fake('id_ID')->phoneNumber(),
            'status' => fake()->randomElement(['Active', 'Disabled']),
            'DOJ' => date_format($dojRange, "Y-m-d"),
            'level' => fake()->numberBetween(1,5),
            'branch_id' => fake()->numberBetween(1,25),
        ];
    }
}
