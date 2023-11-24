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
            'cname' => fake()->name(),
            'sname' => fake()->name(),
            'manufacturer' => fake()->name(),
            'remain' => fake()->numberBetween(1000, 2000),
            'cost' => fake()->numberBetween(1000, 2000),
            'category_id' =>Category::factory()
        ];
    }
}
