<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Uom>
 */
class UomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $units = [
            ['code' => 'pz', 'name' => 'Pieza'],
            ['code' => 'kg', 'name' => 'Kilogramo'],
            ['code' => 'gr', 'name' => 'Gramo'],
            ['code' => 'lt', 'name' => 'Litro'],
            ['code' => 'ml', 'name' => 'Mililitro'],
            ['code' => 'caja', 'name' => 'Caja'],
            ['code' => 'pack', 'name' => 'Pack'],
            ['code' => 'docena', 'name' => 'Docena'],
            ['code' => 'metro', 'name' => 'Metro'],
            ['code' => 'cm', 'name' => 'Centímetro'],
        ];

        $unit = $this->faker->randomElement($units);
        
        return [
            'code' => $unit['code'] . '-' . $this->faker->unique()->randomNumber(3),
            'name' => $unit['name'] . ' ' . $this->faker->word(),
        ];
    }
}
