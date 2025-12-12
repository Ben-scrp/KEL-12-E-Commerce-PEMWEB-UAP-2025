<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Saldo Toko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Kartu Saldo --}}
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900">
                             <h3 class="text-lg font-medium text-gray-500 mb-2">Total Saldo Aktif</h3>
                             <p class="text-3xl font-bold text-indigo-600">
                                Rp {{ number_format($balance->balance, 0, ',', '.') }}
                             </p>
                             <div class="mt-6">
                                 <a href="{{ route('seller.withdrawals.create') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                     Tarik Dana
                                 </a>
                                 <a href="{{ route('seller.withdrawals.index') }}" class="block w-full text-center mt-2 px-4 py-2 border border-gray-300 rounded hover:bg-gray-50">
                                     Riwayat Penarikan
                                 </a>
                             </div>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Mutasi --}}
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Riwayat Mutasi Saldo</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse($history as $record)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-500">{{ $record->created_at->format('d M Y H:i') }}</td>
                                                <td class="px-4 py-2 text-sm">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $record->type === 'credit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $record->type === 'credit' ? 'Pemasukan' : 'Pengeluaran' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2 text-sm font-medium {{ $record->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $record->type === 'credit' ? '+' : '-' }} Rp {{ number_format($record->amount, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-500">{{ $record->remarks }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada riwayat mutasi.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $history->links() }}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
