<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'stock', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function addStock($quantity, $notes = null)
    {
        $this->inventories()->create([
            'quantity' => $quantity,
            'movement_type' => 'in',
            'notes' => $notes,
        ]);

        $this->stock += $quantity;
        $this->save();
    }

    public function removeStock($quantity, $notes = null)
    {
        $this->inventories()->create([
            'quantity' => $quantity,
            'movement_type' => 'out',
            'notes' => $notes,
        ]);

        $this->stock -= $quantity;
        $this->save();
    }
        // Calcul de la note moyenne des avis
        public function averageRating()
        {
            return $this->reviews()->avg('rating'); // Calcule la moyenne de la colonne 'rating'
        }

}
