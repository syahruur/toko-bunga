<div>
    <h1 class="text-2xl font-bold mb-6 text-pink-400 drop-shadow">Riwayat Pesanan</h1>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-2">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari pesanan..." class="w-full sm:w-64 border border-pink-700 bg-zinc-900 text-pink-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 transition" />
        <select wire:model="perPage" class="w-full sm:w-32 border border-pink-700 bg-zinc-900 text-pink-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 transition">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
        </select>
    </div>
    <div class="bg-zinc-800 rounded-2xl p-8 shadow-lg flex flex-col items-center w-full">
        @if($orders->isEmpty())
            <p class="text-pink-200 text-lg font-semibold">Anda belum memiliki riwayat pesanan.</p>
        @else
            <div class="space-y-8 w-full">
                @foreach($orders as $order)
                    <div class="rounded-xl border border-zinc-700 bg-zinc-900 shadow-md hover:shadow-pink-700/30 transition p-6 group">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
                            <div class="flex items-center gap-3">
                                <span class="font-semibold text-pink-200 text-lg">#{{ $order->id }}</span>
                                <span class="text-xs text-zinc-400">{{ $order->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                    {{
                                        $order->status === 'pending' ? 'bg-pink-900 text-pink-200' :
                                        ($order->status === 'processing' ? 'bg-yellow-900 text-yellow-200' :
                                        ($order->status === 'completed' ? 'bg-green-900 text-green-200' : 'bg-zinc-700 text-zinc-200'))
                                    }}">
                                    @if($order->status === 'pending')
                                        <svg class="w-3 h-3 mr-1 text-pink-400" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="10"/></svg>
                                    @elseif($order->status === 'processing')
                                        <svg class="w-3 h-3 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="10"/></svg>
                                    @elseif($order->status === 'completed')
                                        <svg class="w-3 h-3 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="10"/></svg>
                                    @else
                                        <svg class="w-3 h-3 mr-1 text-zinc-400" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="10"/></svg>
                                    @endif
                                    {{ ucfirst($order->status) }}
                                </span>
                                @if($order->status === 'pending')
                                    <button x-data @click.prevent="Swal.fire({title: 'Batalkan pesanan ini?',text: 'Tindakan ini tidak dapat dibatalkan.',icon: 'warning',showCancelButton: true,confirmButtonText: 'Batalkan',cancelButtonText: 'Batal',reverseButtons: true,}).then((result) => {if (result.isConfirmed) {$wire.cancel({{ $order->id }});}});" class="ml-2 px-3 py-1 rounded-lg border border-pink-600 text-pink-400 bg-zinc-800 hover:bg-pink-900 hover:text-pink-100 font-medium text-xs transition">Batalkan</button>
                                @endif
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-2 mb-2">
                            <div class="text-sm text-pink-100"><span class="font-semibold">Alamat:</span> {{ $order->shipping_address }}</div>
                            <div class="text-sm text-pink-100"><span class="font-semibold">Penerima:</span> {{ $order->recipient_name }} ({{ $order->recipient_phone }})</div>
                        </div>
                        @if($order->notes)
                            <div class="text-xs text-pink-300 mb-2 italic">Catatan: {{ $order->notes }}</div>
                        @endif
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm mb-2 border-collapse">
                                <thead>
                                    <tr class="text-pink-300 bg-zinc-900">
                                        <th class="py-1 px-2 text-left">Produk</th>
                                        <th class="py-1 px-2 text-left">Harga</th>
                                        <th class="py-1 px-2 text-left">Jumlah</th>
                                        <th class="py-1 px-2 text-left">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr class="border-b border-zinc-800 last:border-0 hover:bg-zinc-800/60 transition">
                                            <td class="text-pink-100 py-1 px-2">{{ $item->product->name }}</td>
                                            <td class="text-pink-100 py-1 px-2">Rp{{ number_format($item->price,0,',','.') }}</td>
                                            <td class="text-pink-100 py-1 px-2">{{ $item->quantity }}</td>
                                            <td class="text-pink-100 py-1 px-2">Rp{{ number_format($item->price * $item->quantity,0,',','.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right text-pink-200 font-bold text-lg mt-2">Total: Rp{{ number_format($order->total_amount,0,',','.') }}</div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
