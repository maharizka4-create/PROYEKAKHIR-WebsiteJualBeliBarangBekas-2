<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReBarang - Jual Beli Barang Bekas</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-stone-50 text-stone-800">

    <header class="sticky top-0 z-10 bg-white/70 backdrop-blur border-b border-stone-200">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white font-bold flex items-center justify-center">R</div>
                <span class="text-xl font-bold text-stone-900">ReBarang</span>
            </div>
            <nav class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-stone-700 font-semibold text-sm hover:bg-stone-100">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-700">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8">
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-700 px-8 py-16 md:px-14">
            <div class="absolute -top-20 right-24 w-72 h-72 rounded-full bg-emerald-400/40 blur-3xl"></div>
            <div class="absolute -bottom-24 right-0 w-64 h-64 rounded-full bg-amber-300/30 blur-3xl"></div>
            <div class="relative max-w-xl">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/15 border border-white/30 backdrop-blur text-emerald-100 text-sm font-semibold">Thrift cerdas, hemat dan tetap gaya</span>
                <h1 class="mt-4 text-4xl md:text-5xl font-bold leading-tight text-white">Barang bekas pilihan, kondisi jelas, harga bersahabat.</h1>
                <p class="mt-4 text-white/80">Baju, sepatu, tas, dan lainnya dari penjual terpercaya. Setiap barang diperiksa admin sebelum tampil.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-white text-emerald-700 font-semibold">Mulai belanja</a>
                    <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-white/15 border border-white/40 backdrop-blur text-white font-semibold">Jual barangmu</a>
                </div>
            </div>
        </section>

        <section class="mt-10 grid gap-5 md:grid-cols-3">
            <div class="bg-white border border-stone-200 rounded-2xl p-6">
                <div class="text-emerald-600 font-bold">1. Daftar</div>
                <p class="mt-2 text-sm text-stone-600">Buat akun sebagai pembeli atau penjual.</p>
            </div>
            <div class="bg-white border border-stone-200 rounded-2xl p-6">
                <div class="text-emerald-600 font-bold">2. Barang diperiksa</div>
                <p class="mt-2 text-sm text-stone-600">Admin memeriksa barang sebelum tampil di katalog.</p>
            </div>
            <div class="bg-white border border-stone-200 rounded-2xl p-6">
                <div class="text-emerald-600 font-bold">3. Beli dan jual</div>
                <p class="mt-2 text-sm text-stone-600">Pembeli memilih barang, penjual memproses pesanan.</p>
            </div>
        </section>
    </main>

    <footer class="border-t border-stone-200 py-6 text-center text-sm text-stone-500">
        ReBarang - Marketplace barang bekas. Project Akhir Praktikum PBWL.
    </footer>
</body>
</html>