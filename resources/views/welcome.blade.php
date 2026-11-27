<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SEKENOVA - Jual Beli Barang Bekas</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-coklat-50 text-coklat-950">

    <!-- HEADER -->
    <header class="sticky top-0 z-50 bg-white border-b border-coklat-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">

            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-coklat-900 text-white flex items-center justify-center font-extrabold text-xl">
                    S
                </div>

                <div>
                    <h1 class="text-xl font-extrabold tracking-widest text-coklat-900">
                        SEKENOVA
                    </h1>
                    <p class="text-xs text-coklat-600">
                        Every item deserves a second story
                    </p>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}" class="font-semibold text-coklat-900 hover:text-coklat-600">
                    Beranda
                </a>

                <a href="{{ route('catalog.index') }}" class="font-semibold text-coklat-700 hover:text-coklat-900">
                    Katalog
                </a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-2.5 rounded-xl bg-coklat-900 text-white font-semibold hover:bg-coklat-800 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline-block px-5 py-2.5 rounded-xl text-coklat-900 font-semibold hover:bg-coklat-100 transition">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-5 py-2.5 rounded-xl bg-coklat-900 text-white font-semibold hover:bg-coklat-800 transition">
                        Daftar
                    </a>
                @endauth
            </div>

        </div>
    </header>



    <!-- HERO SECTION -->
    <main>
        <section class="max-w-7xl mx-auto px-6 pt-10 pb-12">

            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-coklat-950 via-coklat-800 to-coklat-600 px-7 py-8 md:px-14 md:py-10">

                <div class="absolute -top-20 -right-16 w-80 h-80 rounded-full bg-coklat-300/20 blur-3xl"></div>
                <div class="absolute -bottom-24 right-40 w-72 h-72 rounded-full bg-amber-200/20 blur-3xl"></div>

                <div class="relative max-w-2xl">

                    <span class="inline-block px-5 py-2 rounded-full bg-white/15 border border-white/30 text-amber-100 text-sm font-semibold">
                        Marketplace Barang Bekas Berkualitas
                    </span>

                    <h2 class="mt-5 text-3xl md:text-5xl font-extrabold leading-tight text-white">
                        Temukan Barang Favorit,
                        <span class="text-amber-200">Mulai Cerita Baru.</span>
                    </h2>

                    <p class="mt-4 text-base md:text-lg leading-relaxed text-white/85">
                        Belanja barang bekas berkualitas dengan harga bersahabat.
                        Temukan pakaian, tas, sepatu, dan berbagai kebutuhan lainnya
                        melalui SEKENOVA.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">

                        <a href="{{ route('catalog.index') }}"
                        class="px-6 py-3 rounded-xl bg-amber-100 text-coklat-950 font-bold hover:bg-white transition shadow-lg">
                            Jelajahi Katalog
                        </a>

                        @guest
                        <a href="{{ route('register') }}"
                        class="px-6 py-3 rounded-xl border border-white/50 text-white font-bold hover:bg-white/10 transition">
                            Mulai Bergabung
                        </a>
                        @endguest

                    </div>

                    <div class="mt-8 flex flex-wrap gap-8 text-white/90">

                        <div>
                            <p class="text-xl font-extrabold">Hemat</p>
                            <p class="text-sm text-white/70">Harga bersahabat</p>
                        </div>

                        <div>
                            <p class="text-xl font-extrabold">Pilihan</p>
                            <p class="text-sm text-white/70">Beragam kategori</p>
                        </div>

                        <div>
                            <p class="text-xl font-extrabold">Terpercaya</p>
                            <p class="text-sm text-white/70">Melalui pemeriksaan Admin</p>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- KEUNGGULAN -->
        <section class="max-w-7xl mx-auto px-6 py-12">

            <div class="text-center mb-12">
                <span class="text-sm font-bold tracking-widest uppercase text-coklat-600">
                    Mengapa SEKENOVA?
                </span>

                <h2 class="mt-3 text-3xl md:text-4xl font-extrabold text-coklat-950">
                    Belanja Lebih Bijak, Hidup Lebih Hemat
                </h2>

                <p class="mt-4 text-coklat-600 max-w-2xl mx-auto">
                    Kami menghadirkan pengalaman jual beli barang bekas
                    yang praktis, nyaman, dan mudah diakses.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white border border-coklat-200 rounded-2xl p-8 shadow-sm">
                    <div class="w-14 h-14 rounded-xl bg-coklat-100 flex items-center justify-center text-2xl">
                        ♻️
                    </div>

                    <h3 class="mt-5 text-xl font-bold text-coklat-900">
                        Belanja Berkelanjutan
                    </h3>

                    <p class="mt-3 text-coklat-600 leading-relaxed">
                        Memberikan kesempatan kedua bagi barang bekas
                        agar tetap bermanfaat dan memiliki nilai.
                    </p>
                </div>

                <div class="bg-white border border-coklat-200 rounded-2xl p-8 shadow-sm">
                    <div class="w-14 h-14 rounded-xl bg-coklat-100 flex items-center justify-center text-2xl">
                        🛍️
                    </div>

                    <h3 class="mt-5 text-xl font-bold text-coklat-900">
                        Pilihan Beragam
                    </h3>

                    <p class="mt-3 text-coklat-600 leading-relaxed">
                        Temukan berbagai produk mulai dari fashion,
                        perlengkapan, hingga kebutuhan lainnya.
                    </p>
                </div>

                <div class="bg-white border border-coklat-200 rounded-2xl p-8 shadow-sm">
                    <div class="w-14 h-14 rounded-xl bg-coklat-100 flex items-center justify-center text-2xl">
                        ✓
                    </div>

                    <h3 class="mt-5 text-xl font-bold text-coklat-900">
                        Produk Terverifikasi
                    </h3>

                    <p class="mt-3 text-coklat-600 leading-relaxed">
                        Produk yang ditampilkan dalam katalog telah
                        melalui proses persetujuan Admin.
                    </p>
                </div>

            </div>
        </section>


        <!-- CARA KERJA -->
        <section class="bg-white border-y border-coklat-200 mt-12">

            <div class="max-w-7xl mx-auto px-6 py-16">

                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-coklat-950">
                        Bagaimana SEKENOVA Bekerja?
                    </h2>

                    <p class="mt-3 text-coklat-600">
                        Proses jual beli yang mudah dalam beberapa langkah.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto rounded-full bg-coklat-900 text-white flex items-center justify-center text-2xl font-extrabold">
                            1
                        </div>

                        <h3 class="mt-5 font-bold text-xl text-coklat-900">
                            Daftar Akun
                        </h3>

                        <p class="mt-3 text-coklat-600">
                            Buat akun untuk menikmati layanan
                            SEKENOVA sebagai pengguna.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto rounded-full bg-coklat-900 text-white flex items-center justify-center text-2xl font-extrabold">
                            2
                        </div>

                        <h3 class="mt-5 font-bold text-xl text-coklat-900">
                            Jelajahi Katalog
                        </h3>

                        <p class="mt-3 text-coklat-600">
                            Cari dan pilih barang bekas sesuai
                            kebutuhan dan keinginan.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto rounded-full bg-coklat-900 text-white flex items-center justify-center text-2xl font-extrabold">
                            3
                        </div>

                        <h3 class="mt-5 font-bold text-xl text-coklat-900">
                            Mulai Transaksi
                        </h3>

                        <p class="mt-3 text-coklat-600">
                            Lanjutkan proses pembelian sesuai
                            mekanisme transaksi yang tersedia.
                        </p>
                    </div>

                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('catalog.index') }}"
                       class="inline-block px-8 py-4 rounded-xl bg-coklat-900 text-white font-bold hover:bg-coklat-800 transition">
                        Lihat Katalog Sekarang
                    </a>
                </div>

            </div>
        </section>

    </main>


    <!-- FOOTER -->
    <footer class="bg-coklat-950 text-white">

        <div class="max-w-7xl mx-auto px-6 py-10">

            <div class="flex flex-col md:flex-row justify-between gap-8">

                <div>
                    <h2 class="text-2xl font-extrabold tracking-widest">
                        SEKENOVA
                    </h2>

                    <p class="mt-3 text-coklat-200 max-w-md leading-relaxed">
                        Marketplace barang bekas yang memberikan
                        kesempatan baru bagi setiap barang.
                    </p>
                </div>

                <div>
                    <h3 class="font-bold text-lg">Navigasi</h3>

                    <div class="mt-4 flex flex-col gap-3 text-coklat-200">
                        <a href="{{ url('/') }}" class="hover:text-white">Beranda</a>
                        <a href="{{ route('catalog.index') }}" class="hover:text-white">Katalog</a>

                        @guest
                            <a href="{{ route('login') }}" class="hover:text-white">Masuk</a>
                            <a href="{{ route('register') }}" class="hover:text-white">Daftar</a>
                        @endguest
                    </div>
                </div>

            </div>

            <div class="border-t border-coklat-700 mt-10 pt-6 text-center text-sm text-coklat-300">
                &copy; {{ date('Y') }} SEKENOVA.
                Every item deserves a second story.
            </div>

        </div>
    </footer>

</body>
</html>