<?php

namespace App\Livewire\Search;

use Livewire\Component;
use App\Models\Product;

class ProductSearch extends Component
{
    public $query = '';
    public $products = [];

    public function updatedQuery()
    {
        $this->search();
    }

    public function search()
    {
        $this->products = Product::where('name', 'like', '%'.$this->query.'%')
            ->orWhere('description', 'like', '%'.$this->query.'%')
            ->take(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.search.product-search');
    }
}