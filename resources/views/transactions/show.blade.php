<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Transaksi') }}
            </h2>
            <div class="flex space-x-2">
                <button onclick="printReceipt()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Struk
                </button>
                <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Informasi Transaksi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Kode Transaksi</p>
                            <p class="font-medium">{{ $transaction->transaction_code }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Tanggal</p>
                            <p class="font-medium">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="font-medium">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($transaction->status == 'completed') bg-green-100 text-green-800 
                                    @elseif($transaction->status == 'pending') bg-yellow-100 text-yellow-800 
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="font-medium">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Detail Item</h3>
                    
                    <table class="w-full border-collapse bg-gray-50">
                        <thead>
                            <tr>
                                <th class="w-1/5 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">NAMA ITEM</th>
                                <th class="w-1/5 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">HARGA</th>
                                <th class="w-1/5 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">JUMLAH</th>
                                <th class="w-1/5 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->transactionItems as $item)
                                <tr class="hover:bg-blue-100">
                                    <td class="p-3 border-b text-center">{{ $item->item->name }}</td>
                                    <td class="p-3 border-b text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="p-3 border-b text-center">{{ $item->quantity }}</td>
                                    <td class="p-3 border-b text-center">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="p-3 border-b text-right font-bold">Total:</td>
                                <td class="p-3 border-b text-center font-bold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    @if($transaction->status == 'pending')
                        <div class="mt-6 flex justify-end">
                            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Konfirmasi Pembayaran
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Template Struk untuk Dicetak -->
    <div id="receipt-template" class="hidden">
        <div style="width: 300px; font-family: 'Courier New', monospace; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 10px;">
                <h2 style="margin: 5px 0;">ShopTr</h2>
                <p style="margin: 5px 0;">Struk Pembelian</p>
                <p style="margin: 5px 0;">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                <p style="margin: 5px 0;">No: {{ $transaction->transaction_code }}</p>
            </div>
            <div style="border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 10px 0; margin-bottom: 10px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Item</th>
                            <th style="text-align: right;">Qty</th>
                            <th style="text-align: right;">Harga</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->transactionItems as $item)
                            <tr>
                                <td style="text-align: left;">{{ $item->item->name }}</td>
                                <td style="text-align: right;">{{ $item->quantity }}</td>
                                <td style="text-align: right;">{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td style="text-align: right;">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-bottom: 10px;">
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: right; font-weight: bold;">Total:</td>
                        <td style="text-align: right; font-weight: bold;">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <p>Terima Kasih Atas Kunjungan Anda</p>
            </div>
        </div>
    </div>

    <script>
        function printReceipt() {
            const printContents = document.getElementById('receipt-template').innerHTML;
            const originalContents = document.body.innerHTML;
            
            document.body.innerHTML = printContents;
            
            window.print();
            
            document.body.innerHTML = originalContents;
        }
    </script>
</x-app-layout>