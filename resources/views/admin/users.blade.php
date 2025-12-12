<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen User & Store') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-semibold mb-3">Daftar Semua User</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="py-2 px-4 text-left">Nama</th>
                                <th class="py-2 px-4 text-left">Email</th>
                                <th class="py-2 px-4 text-left">Role</th>
                                <th class="py-2 px-4 text-left">Punya Toko?</th>
                                <th class="py-2 px-4 text-left">Nama Toko</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 px-4">{{ $user->name }}</td>
                                    <td class="py-2 px-4">{{ $user->email }}</td>
                                    <td class="py-2 px-4">
                                        <span class="px-2 py-1 bg-gray-200 rounded text-xs">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4">
                                        @if($user->store)
                                            <span class="text-green-600 font-bold">&#10003; Ya</span>
                                        @else
                                            <span class="text-gray-400">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4">
                                        @if($user->store)
                                            {{ $user->store->name }}
                                            @if($user->store->is_verified)
                                                <span class="ml-1 text-xs bg-blue-100 text-blue-600 px-1 rounded">Verified</span>
                                            @else
                                                <span class="ml-1 text-xs bg-yellow-100 text-yellow-600 px-1 rounded">Pending</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">
                        &larr; Kembali ke Dashboard
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
