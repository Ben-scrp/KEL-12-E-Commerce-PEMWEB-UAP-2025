<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Toko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <h3 class="text-lg font-semibold mb-3">Daftar Toko Belum Terverifikasi</h3>

                @if($stores->isEmpty())
                    <p class="text-gray-500">Tidak ada toko yang perlu diverifikasi saat ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="py-2 px-4 text-left">Nama Toko</th>
                                    <th class="py-2 px-4 text-left">Pemilik</th>
                                    <th class="py-2 px-4 text-left">Kota</th>
                                    <th class="py-2 px-4 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stores as $store)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4">{{ $store->name }}</td>
                                        <td class="py-2 px-4">{{ $store->user->name }}</td>
                                        <td class="py-2 px-4">{{ $store->city }}</td>
                                        <td class="py-2 px-4 flex gap-2">
                                            <form action="{{ route('admin.verify.store', $store->id) }}" method="POST">
                                                @csrf
                                                <button type="submit">Verifikasi</button>
                                            </form>

                                            <form action="{{ route('admin.verification.reject', $store->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-red-600">Tolak</button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">
                        &larr; Kembali ke Dashboard
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
