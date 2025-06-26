<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col gap-6">
        <h1 class="text-2xl font-bold text-zinc-100 mb-2">Dashboard</h1>
        @auth
            <livewire:dashboard-chart />
            @if(auth()->user()->isAdmin())
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow flex flex-col items-center">
                        <span class="text-4xl text-zinc-200 mb-2"><i class="fa fa-users"></i></span>
                        <div class="font-bold text-zinc-100">Manajemen Pengguna</div>
                        <a href="{{ route('admin.pengguna') }}" class="mt-2 text-zinc-300 hover:underline">Lihat</a>
                    </div>
                    <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow flex flex-col items-center">
                        <span class="text-4xl text-zinc-200 mb-2"><i class="fa fa-archive"></i></span>
                        <div class="font-bold text-zinc-100">Manajemen Produk</div>
                        <a href="{{ route('admin.produk') }}" class="mt-2 text-zinc-300 hover:underline">Lihat</a>
                    </div>
                    <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow flex flex-col items-center">
                        <span class="text-4xl text-zinc-200 mb-2"><i class="fa fa-shopping-bag"></i></span>
                        <div class="font-bold text-zinc-100">Manajemen Pesanan</div>
                        <a href="{{ route('admin.pesanan') }}" class="mt-2 text-zinc-300 hover:underline">Lihat</a>
                    </div>
                </div>
            @else
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow flex flex-col items-center">
                        <span class="text-4xl text-zinc-200 mb-2"><i class="fa fa-archive"></i></span>
                        <div class="font-bold text-zinc-100">Lihat Produk</div>
                        <a href="{{ route('produk.index') }}" class="mt-2 text-zinc-300 hover:underline">Lihat</a>
                    </div>
                    <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow flex flex-col items-center">
                        <span class="text-4xl text-zinc-200 mb-2"><i class="fa fa-shopping-cart"></i></span>
                        <div class="font-bold text-zinc-100">Keranjang Belanja</div>
                        <a href="{{ route('keranjang.index') }}" class="mt-2 text-zinc-300 hover:underline">Lihat</a>
                    </div>
                    <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow flex flex-col items-center">
                        <span class="text-4xl text-zinc-200 mb-2"><i class="fa fa-clock"></i></span>
                        <div class="font-bold text-zinc-100">Riwayat Pesanan</div>
                        <a href="{{ route('pesanan.riwayat') }}" class="mt-2 text-zinc-300 hover:underline">Lihat</a>
                    </div>
                    <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow flex flex-col items-center">
                        <span class="text-4xl text-zinc-200 mb-2"><i class="fa fa-search"></i></span>
                        <div class="font-bold text-zinc-100">Lacak Pesanan</div>
                        <a href="{{ route('pesanan.lacak') }}" class="mt-2 text-zinc-300 hover:underline">Lihat</a>
                    </div>
                </div>
            @endif
        @else
            <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow text-center">
                <h2 class="text-lg font-bold mb-2 text-zinc-100">Selamat datang di Toko Bunga!</h2>
                <p class="text-zinc-300">Silakan masuk untuk mengakses fitur dashboard.</p>
            </div>
        @endauth
    </div>
</x-layouts.app>
