<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word . ' Package', 
            'price' => $this->faker->numberBetween(10000, 99999), 
            'status' => $this->faker->boolean ? 1 : 0, 
            'number_love' => $this->faker->numberBetween(0, 10), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
