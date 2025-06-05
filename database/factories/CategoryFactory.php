<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // Pour générer des slugs

class CategoryFactory extends Factory
{
    public function definition()
    {
        $name = $this->faker->unique()->word; // Génère un nom de catégorie unique

        return [
            'name' => $name,
            'slug' => Str::slug($name), // Génère un slug à partir du nom
        ];
    }
}