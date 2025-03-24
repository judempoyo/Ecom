<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;

class Cart extends Component
{
    public $cart = [];
    public $showCartModal = false;

    protected $listeners = ['productAdded' => 'updateCart'];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function updateCart()
    {
        $this->cart = session()->get('cart', []);
        $this->showCartModal = true;
    }

    #[On('add-to-cart')]
public function addToCart($productId)
{
    $product = Product::findOrFail($productId);
    
    $cart = session()->get('cart', []);
    
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity']++;
    } else {
        $cart[$productId] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image,
            "product_id" => $product->id
        ];
    }
    
    session()->put('cart', $cart);
    $this->dispatch('productAdded');
    $this->showCartModal = true;
}

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart');
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            $this->dispatch('productAdded');
        }
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity < 1) return;

        $cart = session()->get('cart');
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
            $this->dispatch('productAdded');
        }
    }

    public function render()
    {
        return view('livewire.cart');
    }
}