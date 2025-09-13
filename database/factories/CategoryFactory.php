<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $medicalCategories = [
            'Medical Devices',
            'Pharmaceuticals',
            'Supplements',
            'Diagnostics',
            'Personal Care',
            'Protective Equipment',
            'Surgical Instruments',
            'Wellness & Fitness',
        ];

        return [
            'name'   => $this->faker->unique()->randomElement($medicalCategories),
            'slug'   => $this->faker->unique()->slug,
            'status' => $this->faker->boolean(100),
        ];
    }
}
