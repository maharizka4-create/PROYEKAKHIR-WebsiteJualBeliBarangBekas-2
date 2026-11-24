<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Penjual</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-700">
                Halo, {{ auth()->user()->name }}. Di sini Anda bisa mengelola barang yang dijual dan pesanan masuk.
            </div>
        </div>
    </div>
</x-app-layout>
