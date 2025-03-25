<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Payment;

class PaymentProcessor extends Component
{
    public $order;
    public $phoneNumber;
    public $network = 'orange'; // Par défaut
    public $networks = ['orange', 'mpesa', 'airtel', 'africell'];
    public $isProcessing = false;
    public $paymentSuccess = false;

    public function mount(Order $order)
    {
        $this->order = $order;
        
        // Vérifier si la commande est déjà payée
        if ($this->order->status === 'paid') {
            return redirect()->route('order.confirmation', ['order' => $this->order->id]);
        }
    }

    public function processPayment()
    {
        $this->validate([
            'phoneNumber' => 'required|regex:/^[0-9]{10,15}$/',
            'network' => 'required|in:orange,mpesa,airtel,africell'
        ]);

        $this->isProcessing = true;

        // Ici vous intégrerez l'API Mobile Money réelle
        // Ceci est une simulation
        try {
            // Créer le paiement
            $payment = Payment::create([
                'order_id' => $this->order->id,
                'amount' => $this->order->total_amount,
                'payment_method' => 'mobile_money',
                'status' => 'pending',
                'phone_number' => $this->phoneNumber,
                'network' => $this->network
            ]);

            // Simuler un délai de traitement
            sleep(3);

            // Mettre à jour le statut (en réalité, cela viendrait d'un webhook)
            $payment->update([
                'status' => 'completed',
                'transaction_id' => 'MM' . now()->timestamp
            ]);

            $this->order->update(['status' => 'paid']);
            $this->paymentSuccess = true;

        } catch (\Exception $e) {
            $this->addError('payment', 'Erreur lors du traitement du paiement');
            $this->isProcessing = false;
        }
    }

    public function render()
    {
        return view('livewire.payment-processor');
    }
}