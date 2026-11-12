@extends('layouts.admin')

@section('header')
<div class="flex flex-col md:flex-row md:items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Edit Produk</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi untuk: <span class="font-bold">{{ $product->name }}</span></p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-coral transition-colors shadow-sm">
            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input Anda:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Kolom Kiri: Info Dasar -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Informasi Dasar</h3>
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-coral focus:ring-brand-coral sm:text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-coral focus:ring-brand-coral sm:text-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700">Kondisi <span class="text-red-500">*</span></label>
                        <select name="condition" id="condition" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-coral focus:ring-brand-coral sm:text-sm">
                            <option value="brand_new" {{ old('condition', $product->condition) == 'brand_new' ? 'selected' : '' }}>Baru / Brand New</option>
                            <option value="like_new" {{ old('condition', $product->condition) == 'like_new' ? 'selected' : '' }}>Seperti Baru / Like New</option>
                            <option value="good" {{ old('condition', $product->condition) == 'good' ? 'selected' : '' }}>Baik / Good</option>
                            <option value="fair" {{ old('condition', $product->condition) == 'fair' ? 'selected' : '' }}>Cukup / Fair</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700">Merk / Brand</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand', $product->brand) }}" placeholder="Opsional" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-coral focus:ring-brand-coral sm:text-sm">
                    </div>
                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700">Ukuran</label>
                        <input type="text" name="size" id="size" value="{{ old('size', $product->size) }}" placeholder="Contoh: M, L, 42" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-coral focus:ring-brand-coral sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Lengkap</label>
                    <textarea name="description" id="description" rows="5" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-coral focus:ring-brand-coral sm:text-sm">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <!-- Kolom Kanan: Harga, Stok & Gambar -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Komersial & Media</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp) <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ old('price', (int)$product->price) }}" required min="0" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-coral focus:ring-brand-coral sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stok Barang <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-coral focus:ring-brand-coral sm:text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk Saat Ini</label>
                    @if($product->main_image)
                        <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
                            @foreach($product->images as $img)
                            <div class="relative w-24 h-24 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ Storage::url($img) }}" alt="Product Image" class="w-full h-full object-cover">
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-500 mb-4 bg-gray-50 p-2 rounded-lg text-center">Tidak ada gambar untuk produk ini.</p>
                    @endif

                    <label class="block text-sm font-medium text-gray-700 mb-2">Timpa Foto Produk (Opsional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-brand-coral hover:bg-red-50 transition-colors">
                        <div class="space-y-2 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-brand-coral hover:text-red-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-coral">
                                    <span>Pilih File Baru</span>
                                    <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/jpeg, image/png, image/webp">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-xs text-red-500 mt-1 font-medium">Perhatian: Mengunggah gambar baru akan menggantikan semua gambar lama.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center mt-6">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="h-4 w-4 text-brand-coral focus:ring-brand-coral border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Produk Aktif (Tampil di Publik)
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end gap-4">
            <a href="{{ route('admin.products.index') }}" class="py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-coral transition-colors">
                Batal
            </a>
            <button type="submit" class="py-2 px-6 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-brand-navy hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-navy transition-all duration-300 transform hover:-translate-y-0.5">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
