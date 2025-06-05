 'name',
         'adress',
         'history',
         'missions_title',
         'missions',
         'culture_title',
         'culture_description',<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Smartphone XYZ',
            'description' => 'Un smartphone haut de gamme.',
            'price' => 799.99,
            'stock' => 50,
            'image' => 'products/smartphone.jpg',
            'category_id' => 1, // Électronique
        ]);

        Product::factory(20)->create(); // Crée 20 produits fictifs
    }
}