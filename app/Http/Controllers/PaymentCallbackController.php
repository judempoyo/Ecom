<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function handleFlutterwaveCallback(Request $request)
    {
        // Vérifier la signature (important pour la sécurité)
        $secretHash = env('FLW_SECRET_HASH');
        $signature = $request->header('verif-hash');
        
        if ($signature !== $secretHash) {
            Log::error('Tentative d\'accès non autorisée au webhook');
            abort(401);
        }

        $txRef = $request->tx_ref;
        $transactionId = $request->transaction_id;
        $status = $request->status;

        // Extraire l'ID de commande depuis la référence
        $orderId = explode('_', $txRef)[1] ?? null;

        if (!$orderId) {
            Log::error('Référence de transaction invalide: ' . $txRef);
            return response()->json(['status' => 'error'], 400);
        }

        $payment = Payment::where('order_id', $orderId)->firstOrFail();
        $order = Order::findOrFail($orderId);

        // Traiter selon le statut
        switch ($status) {
            case 'successful':
                $payment->update([
                    'status' => 'completed',
                    'transaction_id' => $transactionId,
                    'verified_at' => now()
                ]);
                
                $order->update(['status' => 'paid']);
                
                // Envoyer notification
                $this->sendPaymentNotification($order, $payment);
                break;

            case 'failed':
                $payment->update(['status' => 'failed']);
                $order->update(['status' => 'payment_failed']);
                break;

            default:
                Log::info('Statut de paiement non géré: ' . $status);
        }

        return response()->json(['status' => 'success']);
    }

    // Dans PaymentCallbackController
private function verifyFlutterwaveTransaction($transactionId)
{
    $curl = curl_init();
    
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$transactionId}/verify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . env('FLW_SECRET_KEY'),
            "Content-Type: application/json"
        ]
    ]);
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    return json_decode($response, true);
}

    protected function sendPaymentNotification(Order $order, Payment $payment)
    {
        // Envoyer email
        // Mail::to($order->user->email)->send(new PaymentReceived($order));
        
        // Envoyer SMS (exemple avec Twilio)
        // Twilio::message($order->user->phone, "Paiement confirmé pour commande #{$order->id}");
    }
}