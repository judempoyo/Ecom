<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true), // Exemple : "Smartphone XYZ"
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000), // Prix entre 10 et 1000
            'stock' => $this->faker->numberBetween(0, 100), // Stock entre 0 et 100
            'image' => $this->faker->imageUrl(640, 480, 'technics'), // Image aléatoire
            'category_id' => Category::factory(), // Relié à une catégorie
        ];
    }
}