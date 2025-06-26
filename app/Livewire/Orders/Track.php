<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class Track extends Component
{
    public $orderId;
    public $order;

    public function searchOrder()
    {
        $user = Auth::user();
        $this->order = Order::where('id', $this->orderId)
            ->where('user_id', $user->id)
            ->with('items.product')
            ->first();
        if (!$this->order) {
            session()->flash('error', 'Pesanan tidak ditemukan.');
        }
    }

    public function render()
    {
        return view('livewire.orders.track');
    }
}
