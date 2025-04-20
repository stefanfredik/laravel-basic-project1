<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Produk') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            @if($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-lg">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $product->name }}</h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">SKU</label>
                                    <p class="mt-1">{{ $product->sku }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Kategori</label>
                                    <p class="mt-1">{{ $product->category->name }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-700">Harga</label>
                                    <p class="mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-700">Stok</label>
                                    <p class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock_quantity < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                                <p class="mt-1 text-gray-600">{{ $product->description ?: 'Tidak ada deskripsi' }}</p>
                            </div>

                            <div class="border-t pt-4">
                                <h4 class="text-lg font-medium text-gray-900 mb-2">Riwayat Stok</h4>
                                <div class="space-y-2">
                                    @forelse($product->stockReceiptItems as $item)
                                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                                            <div>
                                                <p class="text-sm font-medium">{{ $item->stockReceipt->date }}</p>
                                                <p class="text-xs text-gray-500">{{ $item->stockReceipt->reference_number }}</p>
                                            </div>
                                            <span class="text-green-600">+{{ $item->quantity }}</span>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500">Tidak ada riwayat stok</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>