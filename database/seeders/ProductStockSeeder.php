<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer tous les produits ou un produit spécifique
        $products = Product::all(); // Vous pouvez aussi utiliser Product::where(...)->get() pour filtrer

        foreach ($products as $product) {
            // Ajouter ou retirer du stock aléatoirement pour l'exemple
            $action = rand(0, 1); // 0 pour retirer, 1 pour ajouter
            $quantity = rand(1, 10); // Quantité aléatoire entre 1 et 10

            if ($action) {
                $product->addStock($quantity, 'Réapprovisionnement via seeder');
                $this->command->info("Ajout de $quantity unités au stock du produit ID {$product->id}");
            } else {
                if ($product->stock >= $quantity) {
                    $product->removeStock($quantity, 'Vente via seeder');
                    $this->command->info("Retrait de $quantity unités du stock du produit ID {$product->id}");
                } else {
                    $this->command->error("Stock insuffisant pour retirer $quantity unités du produit ID {$product->id}");
                }
            }
        }
    }
}