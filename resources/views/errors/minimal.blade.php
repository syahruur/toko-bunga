<x-layouts.app :title="__('Terjadi Kesalahan')">
    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="text-center p-8 bg-zinc-800 rounded-xl shadow-lg max-w-lg w-full">
            <div class="text-6xl font-extrabold text-pink-400 mb-4">{{ $code }}</div>
            <div class="text-2xl font-bold text-zinc-100 mb-2">
                @yield('title', __("Terjadi Kesalahan"))
            </div>
            <div class="text-zinc-300 mb-6">
                @yield('message', __("Maaf, terjadi kesalahan pada aplikasi. Silakan kembali ke halaman utama atau hubungi admin jika masalah berlanjut."))
            </div>
            <a href="/" class="inline-block bg-pink-600 text-white px-6 py-2 rounded hover:bg-pink-700 transition">Kembali ke Beranda</a>
        </div>
    </div>
</x-layouts.app>