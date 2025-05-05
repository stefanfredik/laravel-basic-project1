<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kategori') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <x-notification type="success" :message="session('success')" />
            @endif
            @if (session('error'))
                <x-notification type="error" :message="session('error')" />
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search and Filter Form -->
                    <form action="{{ route('categories.index') }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Cari nama atau deskripsi...">
                            </div>
                            <div>
                                <label for="has_products" class="block text-sm font-medium text-gray-700 mb-1">Filter Produk</label>
                                <select name="has_products" id="has_products"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Semua Kategori</option>
                                    <option value="1" {{ request('has_products') === '1' ? 'selected' : '' }}>Ada Produk</option>
                                    <option value="0" {{ request('has_products') === '0' ? 'selected' : '' }}>Tidak Ada Produk</option>
                                </select>
                            </div>
                            <div>
                                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                <div class="flex space-x-2">
                                    <select name="sort" id="sort"
                                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="name" {{ request('sort', 'name') === 'name' ? 'selected' : '' }}>Nama</option>
                                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                                    </select>
                                    <select name="direction" id="direction"
                                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="asc" {{ request('direction', 'asc') === 'asc' ? 'selected' : '' }}>A-Z</option>
                                        <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>Z-A</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Filter
                            </button>
                            <a href="{{ route('categories.index') }}"
                                class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Reset
                            </a>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Produk</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->slug }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->products->count() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('categories.show', $category) }}" class="text-blue-600 hover:text-blue-900 mr-3">Lihat</a>
                                            <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <button type="button" 
                                                class="text-red-600 hover:text-red-900"
                                                onclick="openDeleteModal('{{ route('categories.destroy', $category) }}', 'Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?')"
                                            >
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-delete-confirmation-modal />

    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }

        .animate-notification {
            animation: slideInRight 0.5s ease-out forwards, fadeOut 0.5s ease-in forwards 3s;
        }
    </style>
</x-app-layout>