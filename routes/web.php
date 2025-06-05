<?php

use APp\Http\Controllers\PaymentCallbackController;
use App\Livewire\Orders\OrderList;
use App\Livewire\Product\ProductDetail;
use App\Livewire\Product\ProductList;

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\Order;
use Illuminate\Support\Facades\Route;


Route::get('/', ProductList::class)->name('home');
Route::get('/products', ProductList::class)->name('products.index');
Route::get('/product/{id}', ProductDetail::class)->name('products.show');


Route::middleware(['auth'])->group(function () {
    Route::get('/myorders', OrderList::class)->name('orders.list');
});
Route::get('/orders/{order}/pdf', function (Order $order) {
    return view('order.pdf', ['order' => $order]);
})->name('orders.pdf');
Route::post('/payment/flutterwave-callback', [PaymentCallbackController::class, 'handleFlutterwaveCallback'])
    ->name('payment.flutterwave.callback');
Route::get('/payment/{order}', \App\Livewire\PaymentProcessor::class)
    ->name('payment.process')
    ->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout');
    Route::get('/order/confirmation/{order}', function (Order $order) {
        return view('order.confirmation', compact('order'));
    })->name('order.confirmation');
});

require __DIR__ . '/auth.php';
