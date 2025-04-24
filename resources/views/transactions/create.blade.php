<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checkout') }}
            </h2>
            <a href="{{ route('cart.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Kembali ke Keranjang
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Ringkasan Pesanan</h3>
                    
                    <table class="w-full border-collapse bg-gray-50">
                        <thead>
                            <tr>
                                <th class="w-1/4 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">NAMA ITEM</th>
                                <th class="w-1/4 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">HARGA</th>
                                <th class="w-1/4 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">JUMLAH</th>
                                <th class="w-1/4 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $cartItem)
                                <tr class="hover:bg-blue-100">
                                    <td class="p-3 border-b text-center">{{ $cartItem->item->name }}</td>
                                    <td class="p-3 border-b text-center">Rp {{ number_format($cartItem->item->price, 0, ',', '.') }}</td>
                                    <td class="p-3 border-b text-center">{{ $cartItem->quantity }}</td>
                                    <td class="p-3 border-b text-center">Rp {{ number_format($cartItem->item->price * $cartItem->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="p-3 border-b text-right font-bold">Total:</td>
                                <td class="p-3 border-b text-center font-bold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Informasi Pembayaran</h3>
                    
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="cash">Tunai</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="e-wallet">E-Wallet</option>
                            </select>
                            @error('payment_method')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>
                        
                        <div class="flex items-center justify-between mt-6">
                            <div class="text-lg font-bold">Total Pembayaran: Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Proses Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>