<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Item') }}
            </h2>
            <a href="{{ route('items.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-900 uppercase tracking-widest hover:text-white active:bg-gray-800 active:text-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Item
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

                    <table class="w-full border-collapse bg-gray-50">
                        <thead>
                            <tr>
                                <th class="w-1/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">NAMA</th>
                                <th class="w-1/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">KATEGORI</th>
                                <th class="w-1/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">HARGA</th>
                                <th class="w-1/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">STOK</th>
                                <th class="w-2/6 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr class="hover:bg-blue-100">
                                    <td class="p-3 border-b text-center">{{ $item->name }}</td>
                                    <td class="p-3 border-b text-center">{{ $item->category->name }}</td>
                                    <td class="p-3 border-b text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="p-3 border-b text-center">{{ $item->stock }}</td>
                                    <td class="p-3 border-b text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('items.edit', $item) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('items.destroy', $item) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                            
                                            @if($item->stock > 0)
                                            <form method="POST" action="{{ route('cart.add') }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    Tambah ke Keranjang
                                                </button>
                                            </form>
                                            @else
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed">
                                                Stok Habis
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3 text-center text-gray-500">
                                        Tidak ada data item
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    @if(method_exists($items, 'links'))
                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>