<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Cart;

class Checkout extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $total = 0;
    public $shipping = 0; // Initialisé à 0 par défaut
    public $paymentMethod = 'mobile_money';
    public $includeShipping = false;
    public $address = [
        'street' => '',
        'city' => '',
        'state' => '' // Ajouté pour la RDC
    ];

    // Dans le composant
public $states = [
    'Kinshasa', 'Kongo-Central', 'Kwango', 'Kwilu', 'Mai-Ndombe',
    'Kasai', 'Kasai-Central', 'Kasai-Oriental', 'Lomami', 'Sankuru',
    'Maniema', 'Sud-Kivu', 'Nord-Kivu', 'Ituri', 'Haut-Uele',
    'Tshopo', 'Bas-Uele', 'Nord-Ubangi', 'Mongala', 'Sud-Ubangi',
    'Equateur', 'Tshuapa'
];

    protected $rules = [
        'address.street' => 'required|string|max:255',
        'address.city' => 'required|string|max:255',
        'address.state' => 'required|string|max:100',
        'paymentMethod' => 'required|in:mobile_money,cash,card',
        'includeShipping' => 'boolean'
    ];

    public function mount()
    {
        // Rediriger si non authentifié
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour passer commande');
        }

        $this->cartItems = session()->get('cart', []);
        if (empty($this->cartItems)) {
            return redirect()->route('products.index')->with('error', 'Votre panier est vide');
        }

        $this->calculateTotals();
    }

    public function updatedIncludeShipping($value)
    {
        $this->shipping = $value ? 5.00 : 0; // 5$ de frais de livraison si coché
        $this->calculateTotals();
    }

    protected function calculateTotals()
    {
        $this->subtotal = array_reduce($this->cartItems, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        $this->total = $this->subtotal + $this->shipping;
    }

    public function placeOrder()
{
    $this->validate();

    // Vérifier d'abord que tous les produits sont disponibles
    foreach ($this->cartItems as $id => $item) {
        $product = Product::find($id);
        if (!$product || $product->stock < $item['quantity']) {
            return back()->with('error', "Le produit {$product->name} n'est plus disponible en quantité suffisante");
        }
    }

    // Créer la commande
    $order = Order::create([
        'user_id' => Auth::id(),
        'total_amount' => $this->total,
        'shipping_cost' => $this->shipping,
        'status' => 'pending',
        'payment_method' => $this->paymentMethod,
        'shipping_address' => implode(', ', $this->address)
    ]);

    // Ajouter les articles et réduire le stock
    foreach ($this->cartItems as $id => $item) {
        $product = Product::find($id);
        
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $id,
            'quantity' => $item['quantity'],
            'price' => $item['price']
        ]);

        // Réduire le stock et enregistrer le mouvement d'inventaire
        $product->removeStock($item['quantity'], "Vente - Commande #{$order->id}");
    }

    session()->forget('cart');
    $this->dispatch('productAdded');
    return redirect()->route('order.confirmation', ['order' => $order->id]);
}
    public function render()
    {
        return view('livewire.checkout');
    }
}