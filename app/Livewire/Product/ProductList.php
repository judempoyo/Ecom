<?php

namespace App\Livewire\Product;

use App\Livewire\Cart;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\On;

use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $perPage = 12;
    public $loaded = 12;

    protected $listeners = ['loadMore' => 'loadMore'];

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->when($this->category, function ($query) {
                $query->where('category_id', $this->category);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->take($this->loaded)
            ->get();

        $categories = Category::withCount('products')->get();

        return view('livewire.product.product-list', [
            'products' => $products,
            'categories' => $categories,
            'totalProducts' => Product::count() // Pour savoir quand arrêter de charger
        ]);
    }
    #[On('addToCart')]
    public function addToCart($productId)
    {
        $this->dispatch('add-to-cart', productId: $productId)->to(Cart::class);
    }

    public function loadMore()
    {
        $this->loaded += $this->perPage;
    }
    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }
}
