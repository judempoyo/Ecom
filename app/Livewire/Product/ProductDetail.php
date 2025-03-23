<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class ProductDetail extends Component
{
    public $product;

    public function mount($id)
    {
        $this->product = Product::with('category', 'images', 'reviews')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.product.product-detail');
    }
}