<div>
    <h1 class="text-2xl font-bold mb-4 text-zinc-100">Daftar Produk</h1>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari produk..." class="w-full sm:w-64 border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" />
        <select wire:model="perPage" class="w-full sm:w-32 border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2">
            <option value="6">6</option>
            <option value="12">12</option>
            <option value="24">24</option>
        </select>
    </div>
    @if (session()->has('success'))
        <div class="mb-4 p-2 bg-zinc-800 text-pink-200 rounded">{{ session('success') }}</div>
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-zinc-900 border border-zinc-700 rounded-lg shadow p-4 flex flex-col">
                @if($product->image)
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded mb-2">
                @else
                    <div class="w-full h-40 bg-zinc-800 flex items-center justify-center rounded mb-2 text-zinc-500">Tidak ada gambar</div>
                @endif
                <h2 class="font-bold text-lg text-zinc-100 mb-1">{{ $product->name }}</h2>
                <div class="text-zinc-300 mb-1">Rp{{ number_format($product->price,0,',','.') }}</div>
                <div class="text-xs text-zinc-400 mb-2">Stok: {{ $product->stock }}</div>
                <div class="text-sm text-zinc-400 mb-2">{{ $product->description }}</div>
                @auth
                    <button wire:click="addToCart({{ $product->id }})" class="mt-auto bg-zinc-700 text-zinc-100 px-4 py-2 rounded hover:bg-zinc-600 transition">Tambah ke Keranjang</button>
                @else
                    <a href="/login" class="mt-auto bg-zinc-800 text-zinc-300 px-4 py-2 rounded hover:bg-zinc-700 transition text-center">Masuk untuk membeli</a>
                @endauth
            </div>
        @empty
            <div class="col-span-3 text-center text-zinc-400">Tidak ada produk tersedia.</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
</div>
