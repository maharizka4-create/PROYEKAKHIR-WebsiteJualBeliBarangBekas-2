<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola User</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <div class="p-4 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <form method="GET" class="flex flex-wrap gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / email"
                       class="border-gray-300 rounded-md shadow-sm text-sm">
                <select name="role" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">Semua role</option>
                    @foreach (\App\Models\User::ROLES as $r)
                        <option value="{{ $r }}" @selected(request('role') === $r)>{{ $r }}</option>
                    @endforeach
                </select>
                <button class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">Cari</button>
            </form>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($users as $u)
                            <tr>
                                <td class="px-6 py-3">{{ $u->name }}</td>
                                <td class="px-6 py-3">{{ $u->email }}</td>
                                <td class="px-6 py-3">
                                    <form method="POST" action="{{ route('admin.users.role', $u) }}">
                                        @csrf @method('PATCH')
                                        <select name="role" onchange="this.form.submit()"
                                                class="border-gray-300 rounded-md text-sm"
                                                @disabled($u->id === auth()->id())>
                                            @foreach (\App\Models\User::ROLES as $r)

                                            <option value="{{ $r }}" @selected($u->hasRole($r))>{{ $r }}</option>                                                   @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-3">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                                <td class="px-6 py-3">
                                    @if ($u->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.toggle', $u) }}">
                                            @csrf @method('PATCH')
                                            <button class="text-indigo-600 hover:underline">
                                                {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">Akun Anda</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-6 text-center text-gray-500">Tidak ada user.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $users->links() }}
        </div>
    </div>
</x-admin-layout>
