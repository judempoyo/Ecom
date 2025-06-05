<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition()
    {
        return [
            'order_id' => Order::factory(), // Relié à une commande
            'amount' => $this->faker->randomFloat(2, 50, 1000), // Montant entre 50 et 1000
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']), // Méthode de paiement aléatoire
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']), // Statut aléatoire
        ];
    }
}