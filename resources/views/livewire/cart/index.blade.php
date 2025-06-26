<div>
    <h1 class="text-2xl font-bold mb-6 text-zinc-100 text-center">Keranjang Belanja</h1>
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-900/80 text-red-100 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-800/80 text-green-100 rounded-lg">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-red-800/80 text-red-100 rounded-lg">{{ session('error') }}</div>
    @endif
    <div class="bg-zinc-900 rounded-2xl p-8 shadow-lg w-full max-w-3xl mx-auto flex flex-col gap-6">
        @if($cartItems->isEmpty())
            <div class="flex flex-col items-center justify-center py-12">
                <svg class="w-16 h-16 text-zinc-600 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 0 0 7.48 19h9.04a2 2 0 0 0 1.83-1.3L21 13M7 13V6h13" /></svg>
                <p class="text-zinc-400 text-lg">Keranjang belanja Anda kosong.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-xl">
                <table class="w-full mb-4 text-sm md:text-base">
                    <thead>
                        <tr class="text-left bg-zinc-800 text-zinc-400">
                            <th class="py-2 px-3">Produk</th>
                            <th class="py-2 px-3">Harga</th>
                            <th class="py-2 px-3">Jumlah</th>
                            <th class="py-2 px-3">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr class="border-b border-zinc-800 hover:bg-zinc-800/60 transition">
                                <td class="py-2 px-3 text-zinc-100 flex items-center gap-2">
                                    @if($item->product->image)
                                        <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/'.$item->product->image) }}" class="h-10 w-10 object-cover rounded shadow" alt="{{ $item->product->name }}">
                                    @endif
                                    <span>{{ $item->product->name }}</span>
                                </td>
                                <td class="py-2 px-3 text-zinc-200">Rp{{ number_format($item->product->price,0,',','.') }}</td>
                                <td class="py-2 px-3">
                                    <input type="number" min="1" wire:change="updateQuantity({{ $item->id }}, $event.target.value)" value="{{ $item->quantity }}" class="w-16 border border-zinc-700 bg-zinc-800 text-zinc-100 rounded px-2 py-1 focus:ring-2 focus:ring-pink-600 transition">
                                </td>
                                <td class="py-2 px-3 text-zinc-200">Rp{{ number_format($item->product->price * $item->quantity,0,',','.') }}</td>
                                <td class="py-2 px-3">
                                    <button x-data @click.prevent="Swal.fire({title: 'Yakin hapus item ini dari keranjang?',text: 'Tindakan ini tidak dapat dibatalkan.',icon: 'warning',showCancelButton: true,confirmButtonText: 'Hapus',cancelButtonText: 'Batal',reverseButtons: true,}).then((result) => {if (result.isConfirmed) {$wire.removeItem({{ $item->id }});}});" class="text-pink-400 hover:text-pink-200 transition font-semibold">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                <div class="text-lg font-bold text-zinc-100">Total: <span class="text-pink-400">Rp{{ number_format($total,0,',','.') }}</span></div>
            </div>
            <form wire:submit.prevent="checkout" class="space-y-4 w-full">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold text-zinc-200">Nama Penerima</label>
                        <input type="text" wire:model.defer="recipient_name" class="w-full border border-zinc-700 bg-zinc-800 text-zinc-100 rounded px-3 py-2 focus:ring-2 focus:ring-pink-600 transition">
                        @error('recipient_name')<div class="text-pink-400 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold text-zinc-200">No. Telepon Penerima</label>
                        <input type="text" wire:model.defer="recipient_phone" class="w-full border border-zinc-700 bg-zinc-800 text-zinc-100 rounded px-3 py-2 focus:ring-2 focus:ring-pink-600 transition">
                        @error('recipient_phone')<div class="text-pink-400 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div>
                    <label class="block mb-1 font-semibold text-zinc-200">Alamat Pengiriman</label>
                    <textarea wire:model.defer="shipping_address" class="w-full border border-zinc-700 bg-zinc-800 text-zinc-100 rounded px-3 py-2 focus:ring-2 focus:ring-pink-600 transition"></textarea>
                    @error('shipping_address')<div class="text-pink-400 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block mb-1 font-semibold text-zinc-200">Catatan (opsional)</label>
                    <input type="text" wire:model.defer="notes" class="w-full border border-zinc-700 bg-zinc-800 text-zinc-100 rounded px-3 py-2 focus:ring-2 focus:ring-pink-600 transition">
                    @error('notes')<div class="text-pink-400 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition w-full font-bold text-lg shadow">Buat Pesanan</button>
            </form>
        @endif
    </div>
</div>
