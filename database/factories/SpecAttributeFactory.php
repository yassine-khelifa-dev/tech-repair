<?php

namespace Database\Factories;

use App\Models\SpecAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SpecAttribute>
 */
class SpecAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'code' => fake()->uuid(),
            'input_type' => "select",
            'unit' => "None",
            'is_filterable' => fake()->boolean(),
            'sort_order' => fake()->numberBetween(1,10),
            'is_required' => fake()->boolean()
        ];
    }
}
