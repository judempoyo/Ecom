<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'user_id' => 1,
            'total_amount' => 799.99,
            'status' => 'completed',
        ]);

        Order::factory(15)->create(); // Crée 15 commandes fictives
    }
}