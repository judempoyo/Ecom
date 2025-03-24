<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryNavigation extends Component
{
    public function render()
    {
        return view('livewire.category-navigation', [
            'categories' => Category::withCount('products')->get()
        ]);
    }
}