<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Index extends Component
{
    public $search = '';
    public $perPage = 12;

    public function addToCart($productId)
    {
        $user = Auth::user();
        if (!$user) {
            LivewireAlert::title('Silakan login untuk menambah ke keranjang!')->error()->show();
            return redirect()->route('login');
        }
        $cart = $user->cart()->firstOrCreate([]);
        $item = $cart->items()->where('product_id', $productId)->first();
        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }
        LivewireAlert::title('Produk berhasil ditambahkan ke keranjang!')->success()->show();
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        $products = Product::where('is_available', true)
            ->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.products.index', compact('products'));
    }
}
