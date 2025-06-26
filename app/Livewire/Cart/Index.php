<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Index extends Component
{
    public $cartItems = [];
    public $total = 0;
    public $recipient_name, $recipient_phone, $shipping_address, $notes;
    public $search = '';
    public $deleteId;

    protected $rules = [
        'recipient_name' => 'required|string|max:100',
        'recipient_phone' => 'required|string|max:20',
        'shipping_address' => 'required|string|max:255',
        'notes' => 'nullable|string|max:255',
    ];

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();
        $this->cartItems = $cart ? $cart->items : collect();
        $this->total = $cart ? $cart->getTotal() : 0;
    }

    public function updateQuantity($itemId, $quantity)
    {
        $item = CartItem::find($itemId);
        if ($item && $quantity > 0) {
            $item->quantity = $quantity;
            $item->save();
            $this->refreshCart();
            LivewireAlert::title('Jumlah diperbarui!')->success()->timer(1500)->show();
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Yakin hapus item ini dari keranjang?',
            'text' => 'Tindakan ini tidak dapat dibatalkan.',
            'type' => 'warning',
            'confirmButtonText' => 'Hapus',
            'cancelButtonText' => 'Batal',
            'method' => 'deleteConfirmed',
        ]);
    }

    public function deleteConfirmed()
    {
        $id = $this->deleteId;
        $item = CartItem::find($id);
        if ($item) {
            $item->delete();
            $this->refreshCart();
            LivewireAlert::title('Item dihapus!')->success()->timer(1500)->show();
        }
        $this->deleteId = null;
    }

    public function checkout()
    {
        $this->validate();
        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();
        if (!$cart || $cart->items->isEmpty()) {
            LivewireAlert::title('Keranjang kosong!')->error()->show();
            return;
        }
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $cart->getTotal(),
            'status' => 'pending',
            'shipping_address' => $this->shipping_address,
            'recipient_name' => $this->recipient_name,
            'recipient_phone' => $this->recipient_phone,
            'notes' => $this->notes,
        ]);
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }
        $cart->items()->delete();
        $this->refreshCart();
        $this->reset(['recipient_name', 'recipient_phone', 'shipping_address', 'notes']);
        LivewireAlert::title('Pesanan berhasil dibuat!')->success()->show();
    }

    public function removeItem($id)
    {
        $item = CartItem::find($id);
        if ($item) {
            $item->delete();
            $this->refreshCart();
            LivewireAlert::title('Item dihapus!')->success()->timer(1500)->show();
        }
    }

    public function render()
    {
        $filtered = collect($this->cartItems)->filter(function($item) {
            return stripos($item->product->name, $this->search) !== false;
        });
        return view('livewire.cart.index', [
            'cartItems' => $filtered,
            'total' => $this->total,
        ]);
    }
}
