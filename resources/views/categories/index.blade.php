<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kategori') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-700 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-700 focus:border-gray-900 focus:ring ring-gray-300 disabled: transition ease-in-out duration-150"> <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
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
                                <th class="w-1/3 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">NAMA</th>
                                <th class="w-1/3 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">DESKRIPSI</th>
                                <th class="w-1/3 bg-gray-100 p-3 text-center font-medium uppercase text-gray-600 border-b">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr class="hover:bg-blue-100">
                                <td class="p-3 border-b text-center">{{ $category->name }}</td>
                                <td class="p-3 border-b text-center">{{ $category->description ?: 'Tidak ada deskripsi' }}</td>
                                <td class="p-3 border-b text-center align-middle">
                                    <div class="flex justify-center items-center space-x-3">
                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-blue-700">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-3 text-center text-gray-500">
                                    Tidak ada data kategori
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if(method_exists($categories, 'links'))
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>