<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-3">Welcome, Admin!</h3>
                <p class="mb-5">Kelola aplikasi dari halaman ini.</p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admin.verification') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Verifikasi Toko
                    </a>
                    <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Manajemen User & Store
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
