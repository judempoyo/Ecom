<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OrderList extends Component
{
    public function cancelOrder($orderId)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);

        $order->cancelOrder();

        session()->flash('message', 'Commande annulée avec succès.');
    }

    public function render()
    {
        $orders = Order::with(['items.product', 'payments'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.orders.order-list', [
            'orders' => $orders
        ]);
    }
}