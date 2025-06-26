<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body class="bg-zinc-900 min-h-screen">
    <nav class="bg-zinc-800 shadow mb-6">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-pink-400">Toko Bunga</a>
            <div>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="/admin/pengguna" class="mx-2 text-pink-200 hover:text-pink-400">Pengguna</a>
                        <a href="/admin/produk" class="mx-2 text-pink-200 hover:text-pink-400">Produk</a>
                        <a href="/admin/pesanan" class="mx-2 text-pink-200 hover:text-pink-400">Pesanan</a>
                    @else
                        <a href="/produk" class="mx-2 text-pink-200 hover:text-pink-400">Produk</a>
                        <a href="/keranjang" class="mx-2 text-pink-200 hover:text-pink-400">Keranjang</a>
                        <a href="/pesanan/riwayat" class="mx-2 text-pink-200 hover:text-pink-400">Riwayat Pesanan</a>
                        <a href="/pesanan/lacak" class="mx-2 text-pink-200 hover:text-pink-400">Lacak Pesanan</a>
                    @endif
                    <span class="mx-2 text-pink-700">|</span>
                    <span class="mx-2 text-pink-100">{{ auth()->user()->name }}</span>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="mx-2 text-pink-900 hover:underline">Keluar</button>
                    </form>
                @else
                    <a href="/login" class="mx-2 text-pink-200 hover:text-pink-400">Masuk</a>
                    <a href="/register" class="mx-2 text-pink-200 hover:text-pink-400">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-4">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('livewire:loading', () => {
                let loader = document.getElementById('lw-full-loader');
                if (loader) loader.classList.remove('hidden');
            });
            window.addEventListener('livewire:load', () => {
                let loader = document.getElementById('lw-full-loader');
                if (loader) loader.classList.add('hidden');
            });
            window.addEventListener('livewire:finished', () => {
                let loader = document.getElementById('lw-full-loader');
                if (loader) loader.classList.add('hidden');
            });
        });
    </script>
    <div id="lw-full-loader" class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/80 backdrop-blur-sm hidden">
        <div class="w-16 h-16 border-4 border-zinc-200 border-t-zinc-600 rounded-full animate-spin"></div>
    </div>
</body>
</html>
