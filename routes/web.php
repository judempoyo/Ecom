<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Livewire\Product\ProductList;
use App\Livewire\Product\ProductDetail;
use App\Models\Order;


Route::get('/products', ProductList::class)->name('products.index');
Route::get('/product/{id}', ProductDetail::class)->name('products.show');



Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    
    Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout');
Route::get('/order/confirmation/{order}', function(Order $order) {
    return view('order.confirmation', compact('order'));
})->name('order.confirmation');
});

require __DIR__.'/auth.php';
