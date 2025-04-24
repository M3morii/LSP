<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Keranjang Belanja') }}
            </h2>
            <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-900 uppercase tracking-widest hover:text-white active:bg-gray-800 active:text-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Lanjut Belanja
            </a>
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

                    @if(isset($cartItems) && count($cartItems) > 0)
                        <table class="w-full border-collapse bg-gray-50">
                            <thead>
                                <tr>
                                    <th class="w-1/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">GAMBAR</th>
                                    <th class="w-1/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">NAMA</th>
                                    <th class="w-1/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">HARGA</th>
                                    <th class="w-1/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">JUMLAH</th>
                                    <th class="w-1/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">SUBTOTAL</th>
                                    <th class="w-1/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $cartItem)
                                    <tr class="hover:bg-blue-100">
                                        <td class="p-3 border-b text-center">
                                            @if($cartItem->item->image)
                                                <img src="{{ asset('storage/' . $cartItem->item->image) }}" alt="{{ $cartItem->item->name }}" class="h-16 w-16 object-cover mx-auto">
                                            @else
                                                <div class="h-16 w-16 bg-gray-200 flex items-center justify-center mx-auto">
                                                    <span class="text-gray-500 text-xs">No Image</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="p-3 border-b text-center">{{ $cartItem->item->name }}</td>
                                        <td class="p-3 border-b text-center">Rp {{ number_format($cartItem->item->price, 0, ',', '.') }}</td>
                                        <td class="p-3 border-b text-center">
                                            <form action="{{ route('cart.update', $cartItem->id) }}" method="POST" class="flex items-center justify-center">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="action" value="decrease" class="px-2 py-1 bg-gray-200 rounded-l">-</button>
                                                <input type="text" name="quantity" value="{{ $cartItem->quantity }}" class="w-12 text-center border-t border-b border-gray-200 py-1" readonly>
                                                <button type="submit" name="action" value="increase" class="px-2 py-1 bg-gray-200 rounded-r">+</button>
                                            </form>
                                        </td>
                                        <td class="p-3 border-b text-center">Rp {{ number_format($cartItem->item->price * $cartItem->quantity, 0, ',', '.') }}</td>
                                        <td class="p-3 border-b text-center">
                                            <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="p-3 border-b text-right font-bold">Total:</td>
                                    <td class="p-3 border-b text-center font-bold">Rp {{ number_format($cartItems->sum(function($item) { return $item->item->price * $item->quantity; }), 0, ',', '.') }}</td>
                                    <td class="p-3 border-b"></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Lanjut ke Pembayaran
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="text-gray-500 text-lg">Keranjang belanja Anda kosong</p>
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