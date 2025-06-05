<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CancelPendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-pending-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredPayments = Payment::pendingTooLong()->get();
        
        foreach ($expiredPayments as $payment) {
            $payment->update(['status' => 'expired']);
            $payment->order->update(['status' => 'cancelled']);
            
            // Restaurer le stock
            foreach ($payment->order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }
        
        $this->info("{$expiredPayments->count()} paiements expirés traités.");
    }
}
