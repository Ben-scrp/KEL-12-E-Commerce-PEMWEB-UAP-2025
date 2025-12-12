<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Penarikan Dana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('seller.balance.index') }}" class="mb-4 inline-block text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Saldo Toko</a>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-500">Saldo Saat Ini</h3>
                        <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($balance->balance, 0, ',', '.') }}</p>
                    </div>
                    <div>
                         <a href="{{ route('seller.withdrawals.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                             + Ajukan Penarikan
                         </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Daftar Penarikan</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tujuan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($withdrawals as $withdrawal)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">{{ $withdrawal->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-4 py-2 text-sm font-bold text-gray-900">
                                            Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-500">
                                            <div class="font-medium">{{ $withdrawal->bank_name }}</div>
                                            <div class="text-xs">{{ $withdrawal->bank_account_number }} ({{ $withdrawal->bank_account_name }})</div>
                                        </td>
                                        <td class="px-4 py-2 text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($withdrawal->status === 'approved') bg-green-100 text-green-800
                                                @elseif($withdrawal->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($withdrawal->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada riwayat penarikan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $withdrawals->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
