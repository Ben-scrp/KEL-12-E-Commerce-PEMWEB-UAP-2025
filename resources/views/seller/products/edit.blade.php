<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

             @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
             @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Edit Informasi Produk</h3>
                    
                    <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nama Produk --}}
                            <div class="mb-4 col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kategori --}}
                            <div class="mb-4">
                                <label for="product_category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="product_category_id" id="product_category_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_category_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kondisi --}}
                            <div class="mb-4">
                                <label for="condition" class="block text-sm font-medium text-gray-700">Kondisi</label>
                                <select name="condition" id="condition" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>Baru</option>
                                    <option value="second" {{ old('condition', $product->condition) == 'second' ? 'selected' : '' }}>Bekas</option>
                                </select>
                                @error('condition')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Harga --}}
                            <div class="mb-4">
                                <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0" step="100"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Stok --}}
                            <div class="mb-4">
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('stock')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                             {{-- Berat --}}
                            <div class="mb-4">
                                <label for="weight" class="block text-sm font-medium text-gray-700">Berat (gram)</label>
                                <input type="number" name="weight" id="weight" value="{{ old('weight', $product->weight) }}" required min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('weight')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-4 col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
                                <textarea name="description" id="description" rows="5" required
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                             {{-- Tambah Gambar Baru --}}
                            <div class="mb-4 col-span-2">
                                <label for="images" class="block text-sm font-medium text-gray-700">Tambah Gambar Baru</label>
                                <input type="file" name="images[]" id="images" multiple accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-indigo-50 text-indigo-700
                                              hover:file:bg-indigo-100">
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin menambah gambar.</p>
                                @error('images')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                             <a href="{{ route('seller.products.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Manajemen Gambar --}}
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Manajemen Gambar</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($product->productImages as $image)
                            <div class="relative group border rounded p-2 {{ $image->is_thumbnail ? 'border-indigo-500 ring-2 ring-indigo-500' : 'border-gray-200' }}">
                                <img src="{{ Storage::url($image->image) }}" alt="Product Image" class="w-full h-32 object-cover rounded">
                                
                                @if($image->is_thumbnail)
                                    <span class="absolute top-2 left-2 bg-indigo-600 text-white text-xs px-2 py-1 rounded">Thumbnail</span>
                                @else
                                    <form action="{{ route('seller.products.images.thumbnail', $image) }}" method="POST" class="absolute top-2 left-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-gray-800 text-gray-200 text-xs px-2 py-1 rounded hover:bg-gray-700" title="Jadikan Thumbnail">
                                            Set Thumbnail
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('seller.products.images.destroy', $image) }}" method="POST" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity" onsubmit="return confirm('Hapus gambar ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white p-1 rounded-full hover:bg-red-700" title="Hapus Gambar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
             </div>
        </div>
    </div>
</x-app-layout>
