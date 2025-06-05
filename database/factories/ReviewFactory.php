<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Relié à un utilisateur
            'product_id' => Product::factory(), // Relié à un produit
            'rating' => $this->faker->numberBetween(1, 5), // Note entre 1 et 5
            'comment' => $this->faker->paragraph, // Commentaire aléatoire
        ];
    }
}