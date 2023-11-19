<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Scientific_Name'=>fake()->name(),
            'Commercial_Name'=>fake()->name(),
            'Manufacturer'=>fake()->company(),
            'Remaining'=>fake()->numberBetween(0,2000),
            'cost'=>fake()->numberBetween(2000,10000),
            'category'=>Category::factory()
        ];
    }
}
