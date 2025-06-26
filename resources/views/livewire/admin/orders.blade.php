<div>
    <h1 class="text-2xl font-bold mb-4 text-zinc-100">Manajemen Pesanan</h1>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari pesanan..." class="w-full sm:w-64 border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" />
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
    @if($isEdit)
    <form wire:submit.prevent="update" class="mb-6 space-y-3">
        <div>
            <label class="block mb-1 font-semibold text-zinc-200">Status Pesanan</label>
            <select wire:model.defer="status" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2">
                <option value="pending">Pending</option>
                <option value="processing">Diproses</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
        </div>
        <div>
            <button type="submit" class="bg-zinc-700 text-zinc-100 px-6 py-2 rounded hover:bg-zinc-600 transition">Perbarui Status</button>
            <button type="button" wire:click="$set('isEdit', false)" class="ml-2 px-4 py-2 rounded border border-zinc-700 text-zinc-100">Batal</button>
        </div>
    </form>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full bg-zinc-900 border border-zinc-700 rounded">
            <thead>
                <tr class="bg-zinc-800 text-zinc-200">
                    <th class="px-4 py-2">Pelanggan</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Alamat</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="border-b border-zinc-800">
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">{{ $order->user->name ?? '-' }}</td>
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">Rp{{ number_format($order->total_amount,0,',','.') }}</td>
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">{{ ucfirst($order->status) }}</td>
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">{{ $order->shipping_address }}</td>
                        <td class="border px-4 py-2 border-zinc-800">
                            <button wire:click="edit({{ $order->id }})" class="text-zinc-200 hover:underline mr-2">Edit</button>
                            <button x-data @click.prevent="Swal.fire({title: 'Yakin hapus pesanan ini?',text: 'Tindakan ini tidak dapat dibatalkan.',icon: 'warning',showCancelButton: true,confirmButtonText: 'Hapus',cancelButtonText: 'Batal',reverseButtons: true,}).then((result) => {if (result.isConfirmed) {$wire.delete({{ $order->id }});}});" class="text-zinc-300 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
