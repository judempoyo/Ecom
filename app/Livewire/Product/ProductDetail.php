<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use App\Models\Review;

class ProductDetail extends Component
{
    public Product $product;
    public $quantity = 1;
    public $rating = 0;
    public $comment = '';
    
    public function mount(Product $product)
    {
        $this->product = $product;
    }
    
    public function increment()
    {
        $this->quantity++;
    }
    
    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
    
    public function addToCart()
    {
        // Logique pour ajouter au panier
        $this->dispatch('cartUpdated');
        session()->flash('message', 'Produit ajouté au panier');
    }
    
    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);
        
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $this->product->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);
        
        $this->reset(['rating', 'comment']);
        session()->flash('reviewSubmitted', 'Merci pour votre avis !');
    }
    
    public function render()
    {
        return view('livewire.product.product-detail');
    }
}