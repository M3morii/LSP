<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Transaksi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(isset($transactions) && count($transactions) > 0)
                        <table class="w-full border-collapse bg-gray-50">
                            <thead>
                                <tr>
                                    <th class="w-1/5 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">KODE TRANSAKSI</th>
                                    <th class="w-1/5 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">TANGGAL</th>
                                    <th class="w-1/5 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">TOTAL</th>
                                    <th class="w-1/5 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">STATUS</th>
                                    <th class="w-1/5 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr class="hover:bg-blue-100">
                                        <td class="p-3 border-b text-center">{{ $transaction->transaction_code }}</td>
                                        <td class="p-3 border-b text-center">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                        <td class="p-3 border-b text-center">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                        <td class="p-3 border-b text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($transaction->status == 'completed') bg-green-100 text-green-800 
                                                @elseif($transaction->status == 'pending') bg-yellow-100 text-yellow-800 
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td class="p-3 border-b text-center">
                                            <a href="{{ route('transactions.show', $transaction->id) }}" class="inline-flex items-center px-3 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest text-white hover:bg-blue-700">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if(method_exists($transactions, 'links'))
                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 text-lg">Belum ada riwayat transaksi</p>
                            <div class="mt-4">
                                <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Mulai Belanja
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>