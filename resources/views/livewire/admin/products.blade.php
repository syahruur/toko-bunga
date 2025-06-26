<div>
    <h1 class="text-2xl font-bold mb-4 text-zinc-100">Manajemen Produk</h1>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari produk..." class="w-full sm:w-64 border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" />
        <select wire:model="perPage" class="w-full sm:w-32 border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>
    @if ($errors->any())
        <div class="mb-4 p-2 bg-zinc-800 text-pink-200 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="mb-6 space-y-3" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-semibold text-zinc-200">Nama Produk</label>
                <input type="text" wire:model.defer="name" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-zinc-200">Harga</label>
                <input type="number" wire:model.defer="price" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-zinc-200">Stok</label>
                <input type="number" wire:model.defer="stock" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-zinc-200">Tersedia?</label>
                <select wire:model.defer="is_available" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2">
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </div>
        </div>
        <div>
            <label class="block mb-1 font-semibold text-zinc-200">Deskripsi</label>
            <textarea wire:model.defer="description" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" required></textarea>
        </div>
        <div>
            <label class="block mb-1 font-semibold text-zinc-200">Thumbnail Produk</label>
            <input type="file" wire:model="thumbnail" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2">
            @if($thumbnail)
                <img src="{{ $thumbnail->temporaryUrl() }}" class="h-24 mt-2 rounded" alt="Preview Thumbnail">
            @elseif($image)
                <img src="{{ asset('storage/'.$image) }}" class="h-24 mt-2 rounded" alt="Thumbnail">
            @endif
        </div>
        <div>
            <button type="submit" class="bg-zinc-700 text-zinc-100 px-6 py-2 rounded hover:bg-zinc-600 transition">{{ $isEdit ? 'Perbarui' : 'Tambah' }} Produk</button>
            @if($isEdit)
                <button type="button" wire:click="resetForm" class="ml-2 px-4 py-2 rounded border border-zinc-700 text-zinc-100">Batal</button>
            @endif
        </div>
    </form>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-zinc-900 border border-zinc-700 rounded">
            <thead>
                <tr class="bg-zinc-800 text-zinc-200">
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Stok</th>
                    <th class="px-4 py-2">Tersedia</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-b border-zinc-800">
                        <td class="border px-4 py-2 flex items-center gap-2 border-zinc-800">
                            @if($product->image)
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="h-8 w-8 rounded object-cover">
                            @endif
                            <span class="text-zinc-100">{{ $product->name }}</span>
                        </td>
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">Rp{{ number_format($product->price,0,',','.') }}</td>
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">{{ $product->stock }}</td>
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">{{ $product->is_available ? 'Ya' : 'Tidak' }}</td>
                        <td class="border px-4 py-2 border-zinc-800">
                            <button wire:click="edit({{ $product->id }})" class="text-zinc-200 hover:underline mr-2">Edit</button>
                            <button x-data @click.prevent="Swal.fire({title: 'Yakin hapus produk ini?',text: 'Tindakan ini tidak dapat dibatalkan.',icon: 'warning',showCancelButton: true,confirmButtonText: 'Hapus',cancelButtonText: 'Batal',reverseButtons: true,}).then((result) => {if (result.isConfirmed) {$wire.delete({{ $product->id }});}});" class="text-zinc-300 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
