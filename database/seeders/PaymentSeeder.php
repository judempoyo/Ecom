<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        Payment::create([
            'order_id' => 1,
            'amount' => 799.99,
            'payment_method' => 'credit_card',
            'status' => 'completed',
        ]);

        Payment::factory(15)->create(); // Crée 15 paiements fictifs
    }
}