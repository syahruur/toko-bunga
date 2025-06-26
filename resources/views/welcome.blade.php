<x-layouts.app>
    <div class="w-full max-w-2xl mx-auto mt-16 p-0 relative rounded-2xl shadow-2xl text-center border border-zinc-700 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="/img/flower-hero.jpg" alt="Buket Bunga" class="w-full h-full object-cover brightness-40 grayscale select-none" draggable="false" onerror="this.style.display='none'">
        </div>
        <div class="relative z-10 p-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-pink-400 mb-4 drop-shadow">Selamat Datang di <span class="text-pink-500">Toko Bunga</span></h1>
            <p class="mb-8 text-pink-200 text-lg">Temukan dan pesan bunga favorit Anda dengan mudah.<br>Sistem pembayaran <span class="font-semibold text-pink-400">COD (Bayar di Tempat)</span> tersedia!</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-8">
                <a href="/produk" class="px-8 py-3 bg-pink-500 text-white rounded-lg font-semibold text-lg shadow hover:bg-pink-600 transition">Lihat Produk</a>
                <a href="/login" class="px-8 py-3 bg-zinc-800 text-pink-200 rounded-lg font-semibold text-lg border border-pink-500 hover:bg-pink-900 hover:text-white transition">Masuk</a>
                <a href="/register" class="px-8 py-3 bg-zinc-800 text-pink-200 rounded-lg font-semibold text-lg border border-pink-500 hover:bg-pink-900 hover:text-white transition">Daftar</a>
            </div>
            <p class="text-xs text-pink-400 mt-6">&copy; {{ date('Y') }} Toko Bunga. Dibuat untuk masyarakat Indonesia.</p>
        </div>
    </div>
</x-layouts.app>