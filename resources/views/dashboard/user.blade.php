<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-white">
                    Dashboard Pembeli
                </h2>
                <p class="text-sm text-amber-100 mt-1">
                    Selamat datang kembali, {{ auth()->user()->name }}!
                </p>
            </div>

            <span class="text-sm text-amber-100">
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </x-slot>

    <div class="bg-coklat-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- SAPAAN PERSONAL --}}
            <section class="relative overflow-hidden rounded-2xl
                bg-gradient-to-r from-coklat-950 via-coklat-800 to-coklat-600
                p-8 sm:p-12 shadow-lg">

                <div class="relative z-10 max-w-2xl">
                    <span class="inline-block px-4 py-2 rounded-full
                        bg-white/15 border border-white/20
                        text-amber-100 text-xs font-semibold mb-5">
                        DASHBOARD PEMBELI SEKENOVA
                    </span>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl
                        font-extrabold text-white leading-tight">
                        Halo, {{ auth()->user()->name }}!
                        <br>
                        <span class="text-amber-200">
                            Senang Melihatmu Kembali.
                        </span>
                    </h1>

                    <p class="mt-5 text-sm sm:text-base
                        text-amber-50 leading-relaxed max-w-xl">
                        Selamat datang kembali di SEKENOVA.
                        Temukan berbagai barang bekas berkualitas
                        dengan harga bersahabat dan pilih barang
                        yang sesuai dengan kebutuhanmu.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('catalog.index') }}"
                            class="inline-flex items-center justify-center
                            px-6 py-3 rounded-xl bg-amber-100
                            text-coklat-950 font-bold text-sm
                            hover:bg-amber-200 transition shadow">
                            Jelajahi Katalog
                            <span class="ml-2">→</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="inline-flex items-center justify-center
                            px-6 py-3 rounded-xl border border-white/40
                            text-white font-semibold text-sm
                            hover:bg-white/10 transition">
                            Profil Saya
                        </a>
                    </div>
                </div>

                <div class="absolute -right-16 -bottom-32
                    w-80 h-80 rounded-full bg-amber-300/10"></div>

                <div class="absolute right-20 -top-20
                    w-56 h-56 rounded-full bg-amber-200/10"></div>
            </section>

            {{-- MENU UTAMA --}}
            <section class="mt-10">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-coklat-950">
                        Menu Utama
                    </h3>
                    <p class="text-sm text-coklat-600 mt-1">
                        Akses layanan SEKENOVA dengan mudah.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- KATALOG --}}
                    <a href="{{ route('catalog.index') }}"
                        class="group bg-white rounded-2xl p-6
                        border border-coklat-200 shadow-sm
                        hover:shadow-lg hover:-translate-y-1
                        transition duration-300">

                        <div class="w-14 h-14 rounded-xl
                            bg-amber-100 flex items-center
                            justify-center text-2xl">
                            🛍️
                        </div>

                        <h4 class="mt-5 font-bold text-lg
                            text-coklat-950 group-hover:text-amber-700">
                            Jelajahi Katalog
                        </h4>

                        <p class="mt-2 text-sm text-coklat-600 leading-relaxed">
                            Temukan berbagai pilihan barang bekas
                            berkualitas sesuai kebutuhanmu.
                        </p>

                        <div class="mt-5 text-sm font-bold text-coklat-700">
                            Lihat Katalog →
                        </div>
                    </a>

                    {{-- PROFIL --}}
                    <a href="{{ route('profile.edit') }}"
                        class="group bg-white rounded-2xl p-6
                        border border-coklat-200 shadow-sm
                        hover:shadow-lg hover:-translate-y-1
                        transition duration-300">

                        <div class="w-14 h-14 rounded-xl
                            bg-amber-100 flex items-center
                            justify-center text-2xl">
                            👤
                        </div>

                        <h4 class="mt-5 font-bold text-lg
                            text-coklat-950 group-hover:text-amber-700">
                            Profil Saya
                        </h4>

                        <p class="mt-2 text-sm text-coklat-600 leading-relaxed">
                            Periksa dan perbarui informasi akun
                            serta data pribadimu.
                        </p>

                        <div class="mt-5 text-sm font-bold text-coklat-700">
                            Kelola Profil →
                        </div>
                    </a>

                    {{-- PANDUAN --}}
                    <div class="bg-white rounded-2xl p-6
                        border border-coklat-200 shadow-sm">

                        <div class="w-14 h-14 rounded-xl
                            bg-amber-100 flex items-center
                            justify-center text-2xl">
                            📦
                        </div>

                        <h4 class="mt-5 font-bold text-lg text-coklat-950">
                            Panduan Belanja
                        </h4>

                        <p class="mt-2 text-sm text-coklat-600 leading-relaxed">
                            Kenali cara memilih barang dan
                            menggunakan layanan marketplace SEKENOVA.
                        </p>

                        <div class="mt-5 text-sm font-semibold text-coklat-500">
                            Informasi Belanja
                        </div>
                    </div>

                </div>
            </section>

            {{-- INFORMASI AKUN --}}
            <section class="mt-10 bg-white rounded-2xl
                border border-coklat-200 p-6 sm:p-8 shadow-sm">

                <div class="flex flex-col sm:flex-row
                    sm:items-center sm:justify-between gap-5">

                    <div>
                        <span class="text-xs font-bold uppercase
                            tracking-widest text-coklat-500">
                            Informasi Akun
                        </span>

                        <h3 class="text-xl font-bold text-coklat-950 mt-2">
                            Akun SEKENOVA Kamu
                        </h3>

                        <p class="text-sm text-coklat-600 mt-2">
                            Terima kasih telah menjadi bagian dari
                            komunitas SEKENOVA.
                        </p>
                    </div>

                    <div class="bg-coklat-50 rounded-xl p-5
                        border border-coklat-200 min-w-52">

                        <p class="text-xs text-coklat-500">
                            Nama Pengguna
                        </p>

                        <p class="font-bold text-coklat-950 mt-1">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs text-coklat-500 mt-4">
                            Email
                        </p>

                        <p class="text-sm font-medium text-coklat-800 mt-1 break-all">
                            {{ auth()->user()->email }}
                        </p>

                        <p class="text-xs text-coklat-500 mt-4">
                            Status Akun
                        </p>

                        <span class="inline-block mt-1 px-3 py-1
                            rounded-full bg-green-100 text-green-700
                            text-xs font-bold">
                            Aktif
                        </span>
                    </div>

                </div>
            </section>

            {{-- MOTIVASI --}}
            <section class="mt-10 text-center py-8">
                <h3 class="text-xl font-bold text-coklat-950">
                    Belanja Lebih Bijak, Hidup Lebih Hemat.
                </h3>

                <p class="mt-3 text-sm text-coklat-600">
                    Every item deserves a second story.
                </p>
            </section>

        </div>
    </div>
</x-app-layout>