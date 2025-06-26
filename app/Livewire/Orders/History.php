<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class History extends Component
{
    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $user = Auth::user();
        $orders = $user->orders()
            ->with('items.product')
            ->where(function($q) {
                $q->where('recipient_name', 'like', '%'.$this->search.'%')
                  ->orWhere('status', 'like', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.orders.history', compact('orders'));
    }

    public function cancel($id)
    {
        $user = Auth::user();
        $order = $user->orders()->findOrFail($id);
        if ($order->status === 'pending') {
            $order->delete();
            session()->flash('success', 'Pesanan berhasil dibatalkan.');
        }
    }
}
