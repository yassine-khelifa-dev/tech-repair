<?php

namespace Database\Factories;

use App\Models\SpecAttributeOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SpecAttributeOption>
 */
class SpecAttributeOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => fake()->unique()->word(),
            'label' => fake()->word(),
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
            //  'spec_attribute_id' => $id
        ];
    }
}
