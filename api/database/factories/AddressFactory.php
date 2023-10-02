<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cep' => fake()->numerify('14######'),
            'street' => fake()->streetName(),
            'number' => fake()->numberBetween(1, 100),
            'district' => fake()->colorName(),
            'complement' => fake()->text(20),
            'city' => fake()->city(),
            'state' => fake()->name(),
            'country' => fake()->country()
        ];
    }
}
