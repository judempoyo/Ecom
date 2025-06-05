<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

protected $fillable = [
    'order_id',
    'amount',
    'payment_method',
    'status',
    'phone_number',
    'network',
    'transaction_id' 
];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopePendingTooLong($query)
{
    return $query->where('status', 'pending')
                ->where('created_at', '<', now()->subMinutes(30));
}
}
