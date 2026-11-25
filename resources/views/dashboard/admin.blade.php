<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total pembeli</div>
                    <div class="text-3xl font-semibold text-gray-900">{{ $totalUser }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total penjual</div>
                    <div class="text-3xl font-semibold text-gray-900">{{ $totalPenjual }}</div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <div class="px-6 py-4 border-b font-medium text-gray-800">Pengguna terbaru</div>
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($latestUsers as $u)
                            <tr>
                                <td class="px-6 py-3">{{ $u->name }}</td>
                                <td class="px-6 py-3">{{ $u->email }}</td>
                                <td class="px-6 py-3">{{ $u->getRoleNames()->first() }}</td>                                    <td class="px-6 py-3">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
