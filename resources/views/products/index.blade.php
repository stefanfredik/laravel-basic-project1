<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('products.create') }}"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Tambah Produk</a>
                <a href="{{ route('products.export') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Export</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 space-y-4">
                <!-- Search bar and filter toggle button -->
                <div class="flex gap-4 items-end">
                    <div class="flex-grow">
                        <form action="{{ route('products.index') }}" method="GET" class="flex gap-4">
                            <div class="flex-grow">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari
                                    Produk</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Nama produk atau SKU..." class="w-full px-4 py-2 border rounded">
                            </div>
                            <div class="flex items-end gap-2">
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 whitespace-nowrap">
                                    <i class="fas fa-search mr-2"></i> Cari
                                </button>
                                <button type="button" onclick="toggleFilter()"
                                    class="filter-button px-3 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition-all duration-300 ease-in-out flex items-center gap-2">
                                    <i class="fas fa-filter transition-transform duration-300"></i>
                                    <span class="text-sm">Filter</span>
                                </button>
                                @if (request()->anyFilled(['category', 'stock_status', 'min_price', 'max_price']))
                                    <a href="{{ route('products.index') }}"
                                        class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 whitespace-nowrap">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Advanced filter section -->
                <div id="filterSection" class="hidden bg-gray-50 p-4 rounded-lg shadow-sm" x-data="{ show: false }">
                    <form action="{{ route('products.index') }}" method="GET" class="grid gap-4">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label for="category"
                                    class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select name="category" id="category" class="w-full px-4 py-2 border rounded">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="stock_status" class="block text-sm font-medium text-gray-700 mb-1">Status
                                    Stok</label>
                                <select name="stock_status" id="stock_status" class="w-full px-4 py-2 border rounded">
                                    <option value="">Semua Stok</option>
                                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>
                                        Stok Rendah (< 10) </option>
                                    <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>
                                        Habis (0)
                                    </option>
                                    <option value="available"
                                        {{ request('stock_status') == 'available' ? 'selected' : '' }}>
                                        Tersedia (>= 10)
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">Harga
                                    Minimum</label>
                                <input type="number" name="min_price" id="min_price"
                                    value="{{ request('min_price') }}" min="0" placeholder="Rp 0"
                                    class="w-full px-4 py-2 border rounded">
                            </div>

                            <div>
                                <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Harga
                                    Maksimum</label>
                                <input type="number" name="max_price" id="max_price"
                                    value="{{ request('max_price') }}" min="0" placeholder="Tidak ada batas"
                                    class="w-full px-4 py-2 border rounded">
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        SKU
                                    </th>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Kategori
                                    </th>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Harga
                                    </th>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Stok
                                    </th>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="flex items-center">
                                                @if ($product->image_path)
                                                    <img src="{{ Storage::url($product->image_path) }}"
                                                        alt="{{ $product->name }}" class="h-10 w-10 rounded-full mr-3">
                                                @endif
                                                <div class="text-sm leading-5 font-medium text-gray-900">
                                                    {{ $product->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900">{{ $product->sku }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900">
                                                {{ $product->category->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-right">
                                            <div class="text-sm leading-5 text-gray-900">Rp
                                                {{ number_format($product->price, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock_quantity < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $product->stock_quantity }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            <a href="{{ route('products.show', $product) }}"
                                                class="bg-blue-600 text-white px-3 py-1 rounded-sm hover:bg-blue-700 mr-1">Lihat</a>
                                            <a href="{{ route('products.edit', $product) }}"
                                                class="bg-yellow-600 text-white px-3 py-1 rounded-sm hover:bg-yellow-700 mr-1">Edit</a>
                                            <button type="button"
                                                class="bg-red-600 text-white px-3 py-1 rounded-sm hover:bg-red-700"
                                                onclick="openDeleteModal('{{ route('products.destroy', $product) }}', 'Apakah Anda yakin ingin menghapus produk {{ $product->name }}?')">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <x-notification type="success" :message="session('success')" />
    @endif
    @if (session('error'))
        <x-notification type="error" :message="session('error')" />
    @endif

    <x-delete-confirmation-modal />

    <script>
        function toggleFilter() {
            const filterSection = document.getElementById('filterSection');
            const filterButton = document.querySelector('.filter-button i');

            if (filterSection.classList.contains('hidden')) {
                filterSection.classList.remove('hidden');
                filterButton.style.transform = 'rotate(180deg)';
            } else {
                filterSection.classList.add('hidden');
                filterButton.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</x-app-layout>
