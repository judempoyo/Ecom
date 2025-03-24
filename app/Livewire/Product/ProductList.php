<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;


    public function render()
    {
        $products = Product::with('category', 'images')->get();
        return view('livewire.product.product-list', ['products' => $products]);
    }
}