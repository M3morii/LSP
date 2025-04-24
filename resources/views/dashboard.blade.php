<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <!-- Statistik Kategori -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-lg font-medium text-gray-700">Total Kategori</div>
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-indigo-600">{{ $categoryCount }}</div>
                        <div class="text-sm text-gray-500 mt-1">Kategori Produk</div>
                    </div>
                </div>

                <!-- Statistik Item -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-lg font-medium text-gray-700">Total Item</div>
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100 text-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-green-600">{{ $itemCount }}</div>
                        <div class="text-sm text-gray-500 mt-1">Produk Tersedia</div>
                    </div>
                </div>

                <!-- Statistik Transaksi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-lg font-medium text-gray-700">Total Transaksi</div>
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-blue-600">{{ $transactionCount }}</div>
                        <div class="text-sm text-gray-500 mt-1">Transaksi Selesai</div>
                    </div>
                </div>

                <!-- Total Penjualan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-lg font-medium text-gray-700">Total Penjualan</div>
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 text-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-yellow-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-500 mt-1">Pendapatan Total</div>
                    </div>
                </div>
            </div>

            <!-- Transaksi Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-700">Transaksi Terbaru</h3>
                        <a href="{{ route('transactions.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
                    </div>
                    
                    @if($latestTransactions->isEmpty())
                        <div class="flex flex-col items-center justify-center py-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500">Belum ada transaksi.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Transaksi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($latestTransactions as $transaction)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->transaction_code }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Item dengan Stok Rendah -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-700">Item dengan Stok Rendah</h3>
                        <a href="{{ route('items.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Kelola Item</a>
                    </div>
                    
                    @if($lowStockItems->isEmpty())
                        <div class="flex flex-col items-center justify-center py-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p class="text-gray-500">Tidak ada item dengan stok rendah.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($lowStockItems as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->category->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ $item->stock }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('items.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
