<div>
    <h1 class="text-2xl font-bold mb-6 text-pink-400 drop-shadow">Lacak Pesanan</h1>
    <div class="bg-zinc-800 rounded-2xl p-8 shadow-lg flex flex-col items-center w-full mb-8">
        @if (session()->has('error'))
            <div class="mb-4 p-3 bg-pink-800 text-pink-100 rounded-lg font-semibold w-full text-center">{{ session('error') }}</div>
        @endif
        <form wire:submit.prevent="searchOrder" class="flex flex-col sm:flex-row items-center gap-3 mb-6 w-full max-w-lg">
            <input type="text" wire:model.defer="orderId" placeholder="Masukkan ID Pesanan" class="w-full border border-pink-700 bg-zinc-900 text-pink-100 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-500 transition" />
            <button type="submit" class="bg-pink-900 text-white px-6 py-2 rounded-lg hover:bg-pink-800 transition font-semibold shadow">Cari</button>
        </form>
        @if($order)
            <div class="rounded-xl border border-zinc-700 bg-zinc-900 shadow-md w-full max-w-2xl p-6">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
                    <div class="flex items-center gap-3">
                        <span class="font-semibold text-pink-200 text-lg">#{{ $order->id }}</span>
                        <span class="text-xs text-zinc-400">{{ $order->created_at->format('d M Y H:i') }}</span>
                    </div>
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
        @endif
    </div>
</div>
