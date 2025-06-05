<?php

namespace App\Livewire\Product;


use App\Livewire\Cart;
use Livewire\Component;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ProductDetail extends Component
{
    public Product $product;
    public $quantity = 1;
    public $rating = 0;
    public $comment = '';
    public $productId; 
    public $hasReviewed = false;

    public function mount($id) 
    {
        $this->productId = $id;
        $this->product = Product::with(['reviews.user' => function($query) {
            $query->select('id', 'name', 'profile_photo'); 
        }, 'images'])->findOrFail($id);

        // Vérifie si l'utilisateur a déjà posté un avis
        if (auth()->check()) {
            $this->hasReviewed = $this->product->reviews()
                ->where('user_id', auth()->id())
                ->exists();
        }
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
    #[On('addToCart')]
    public function addToCart()
    {
        if ($this->product->stock <= 0) {
            session()->flash('error', 'Ce produit est en rupture de stock');
            return;
        }

        $this->dispatch('add-to-cart', 
            productId: $this->product->id,
            quantity: $this->quantity
        )->to(Cart::class);

        session()->flash('message', 'Produit ajouté au panier');
    }
    
    public function submitReview()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Vous devez être connecté pour poster un avis');
            return;
        }

        if ($this->hasReviewed) {
            session()->flash('error', 'Vous avez déjà posté un avis pour ce produit');
            return;
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);
        
        $review = $this->product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);
        
        $this->product->load('reviews.user');
        $this->hasReviewed = true;
        $this->reset(['rating', 'comment']);
        
        session()->flash('reviewSubmitted', 'Merci pour votre avis !');
    }
    
    public function render()
    {
        return view('livewire.product.product-detail', [
            'inStock' => $this->product->stock > 0,
            'hasReviewed' => $this->hasReviewed
        ]);
    }
}