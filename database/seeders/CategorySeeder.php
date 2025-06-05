<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // Pour générer des slugs

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Liste des catégories à créer
        $categories = [
            ['name' => 'Électronique'],
            ['name' => 'Vêtements'],
            ['name' => 'Maison'],
            ['name' => 'Jouets'],
            ['name' => 'Sports'],
            ['name' => 'Beauté'],
            ['name' => 'Alimentation'],
        ];

        // Créer chaque catégorie avec un slug
        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']), // Génère un slug à partir du nom
            ]);
        }
    }
}