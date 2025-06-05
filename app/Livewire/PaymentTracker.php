<?php

namespace App\Livewire;

use Livewire\Component;

class PaymentTracker extends Component
{
    // app/Http/Livewire/PaymentTracker.php
public function render()
{
    $payments = auth()->user()->payments()
        ->with('order')
        ->latest()
        ->paginate(10);

    return view('livewire.payment-tracker', compact('payments'));
}
}
