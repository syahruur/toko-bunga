<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\User;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Orders extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $status, $order_id;
    public $isEdit = false;
    public $deleteId;

    protected $rules = [
        'status' => 'required|string',
    ];

    public function mount()
    {
        // Removed loadOrders, not needed
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $this->order_id = $order->id;
        $this->status = $order->status;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $order = Order::findOrFail($this->order_id);
        // Only allow update if status is pending or processing
        if (!in_array($order->status, ['pending', 'processing'])) {
            LivewireAlert::title('Status hanya bisa diubah jika pesanan masih pending atau sedang diproses!')->error()->show();
            $this->isEdit = false;
            return;
        }
        $oldStatus = $order->status;
        $order->update([
            'status' => $this->status,
        ]);
        // Kurangi stok produk jika status diubah menjadi completed
        if ($oldStatus !== 'completed' && $this->status === 'completed') {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }
        }
        $this->isEdit = false;
        // Removed loadOrders, not needed
        LivewireAlert::title('Status pesanan berhasil diperbarui!')->success()->show();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Yakin hapus pesanan ini?',
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
        Order::findOrFail($id)->delete();
        $this->deleteId = null;
        LivewireAlert::title('Pesanan berhasil dihapus!')->success()->show();
    }

    public function delete($id)
    {
        Order::findOrFail($id)->delete();
        LivewireAlert::title('Pesanan berhasil dihapus!')->success()->show();
    }

    public function render()
    {
        $orders = Order::with('user')
            ->whereHas('user', function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->orWhere('status', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.admin.orders', compact('orders'));
    }
}
