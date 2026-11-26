@php
    $menungguCount = \App\Models\Product::where('status_persetujuan', 'menunggu')->count();
    $menu = [
        ['Dashboard', route('admin.dashboard'), request()->routeIs('admin.dashboard'), 'M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10'],
        ['Kategori', url('/admin/categories'), request()->is('admin/categories*'), 'M7 7h.01M3 11l8.6 8.6a2 2 0 002.8 0l5.2-5.2a2 2 0 000-2.8L11 3H3v8z'],
        ['Kelola User', url('/admin/users'), request()->is('admin/users*'), 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4.13a4 4 0 11-8 0 4 4 0 018 0zm6 0a3 3 0 11-6 0'],
        ['Barang', url('/admin/products'), request()->is('admin/products*'), 'M20 7l-8-4-8 4m16 0v10l-8 4m-8-14v10l8 4m0-10L4 7m8 4l8-4'],
        ['Verifikasi', url('/admin/verifikasi'), request()->is('admin/verifikasi*'), 'M9 12l2 2 4-4m5.6-2A12 12 0 0112 3a12 12 0 01-8.6 3A12 12 0 003 12c0 5.2 3.4 9.6 9 11 5.6-1.4 9-5.8 9-11 0-1.4-.2-2.8-.4-4z'],
        ['Laporan', url('/admin/laporan'), request()->is('admin/laporan*'), 'M9 17v-6m4 6V7m4 10v-4M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z'],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SEKENOVA') }} - Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none !important}</style>
</head>
<body class="font-sans antialiased text-coklat-950 bg-coklat-50">
<div x-data="{ buka: false }" class="min-h-screen lg:flex">

    {{-- Latar gelap saat menu HP terbuka --}}
    <div x-show="buka" x-cloak @click="buka = false" class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>

    {{-- Sidebar --}}
    <aside :class="buka ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-gradient-to-b from-coklat-900 to-coklat-950 text-coklat-100 transition-transform lg:sticky lg:top-0 lg:h-screen">
        <div class="px-6 py-6">
            <p class="text-xl font-bold tracking-widest text-white">SEKENOVA</p>
            <p class="text-xs text-coklat-300">Marketplace Barang Bekas</p>
        </div>

        <nav class="flex-1 space-y-1 px-4">
            @foreach ($menu as [$nama, $link, $aktif, $ikon])
                <a href="{{ $link }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                          {{ $aktif ? 'bg-coklat-600 text-white shadow' : 'text-coklat-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikon }}"/>
                    </svg>
                    <span class="flex-1">{{ $nama }}</span>
                    @if ($nama === 'Verifikasi' && $menungguCount > 0)
                        <span class="rounded-full bg-red-500 px-2 py-0.5 text-xs font-bold text-white">{{ $menungguCount }}</span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="space-y-1 border-t border-white/10 px-4 py-4">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-coklat-200 hover:bg-white/10 hover:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-coklat-200 hover:bg-white/10 hover:text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Konten --}}
    <div class="flex min-h-screen min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-20 flex items-center justify-between border-b border-coklat-100 bg-white/90 px-4 py-3 backdrop-blur sm:px-8">
            <div class="flex items-center gap-3">
                <button @click="buka = true" class="rounded-lg p-2 text-coklat-700 hover:bg-coklat-100 lg:hidden" aria-label="Buka menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <p class="hidden text-sm text-coklat-600 sm:block">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-coklat-500">Admin</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-coklat-700 font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        @isset($header)
            <div class="px-4 pt-6 sm:px-8 [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-coklat-950 [&_p]:text-sm [&_p]:text-coklat-600">
                {{ $header }}
            </div>
        @endisset

        <main class="flex-1 px-4 py-6 sm:px-8">
            {{ $slot }}
        </main>

        <footer class="border-t border-coklat-100 py-4 text-center text-xs text-coklat-500">
            &copy; {{ date('Y') }} SEKENOVA. Every item deserves a second story.
        </footer>
    </div>
</div>
</body>
</html>