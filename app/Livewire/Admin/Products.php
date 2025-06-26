<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Products extends Component
{
    use WithFileUploads, WithPagination;

    public $name, $description, $price, $stock, $image, $is_available = true, $product_id;
    public $isEdit = false;
    public $thumbnail;
    public $search = '';
    public $perPage = 10;
    public $deleteId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'is_available' => 'boolean',
        'thumbnail' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        //
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->name = $this->description = $this->price = $this->stock = $this->image = null;
        $this->is_available = true;
        $this->product_id = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate();
        $imagePath = null;
        if ($this->thumbnail) {
            $imagePath = $this->thumbnail->store('products', 'public');
        }
        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $imagePath,
            'is_available' => $this->is_available,
        ]);
        $this->resetForm();
        LivewireAlert::title('Produk berhasil ditambahkan!')->success()->show();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->image = $product->image;
        $this->is_available = $product->is_available;
        $this->thumbnail = null;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $product = Product::findOrFail($this->product_id);
        $imagePath = $product->image;
        if ($this->thumbnail) {
            $imagePath = $this->thumbnail->store('products', 'public');
        }
        $product->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $imagePath,
            'is_available' => $this->is_available,
        ]);
        $this->resetForm();
        LivewireAlert::title('Produk berhasil diperbarui!')->success()->show();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Yakin hapus produk ini?',
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
        Product::findOrFail($id)->delete();
        $this->deleteId = null;
        LivewireAlert::title('Produk berhasil dihapus!')->success()->show();
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        LivewireAlert::title('Produk berhasil dihapus!')->success()->show();
    }

    public function render()
    {
        $products = Product::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.admin.products', compact('products'));
    }
}
