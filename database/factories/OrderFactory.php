<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Relié à un utilisateur
            'total_amount' => $this->faker->randomFloat(2, 50, 1000), // Montant entre 50 et 1000
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']), // Statut aléatoire
        ];
    }
}