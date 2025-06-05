<?php
namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition()
    {
        return [
            'order_id' => Order::factory(), // Relié à une commande
            'product_id' => Product::factory(), // Relié à un produit
            'quantity' => $this->faker->numberBetween(1, 10), // Quantité entre 1 et 10
            'price' => $this->faker->randomFloat(2, 10, 500), // Prix entre 10 et 500
        ];
    }
}