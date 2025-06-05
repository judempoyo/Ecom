<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_amount', 'status'];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les articles de la commande
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relation avec les paiements
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function cancelOrder()
{
    if ($this->status === 'cancelled') return;

    foreach ($this->items as $item) {
        $product = $item->product;
        $product->addStock($item->quantity, "Annulation commande #{$this->id}");
    }

    $this->status = 'cancelled';
    $this->save();
}
}