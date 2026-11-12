@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumbs -->
    <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="hover:text-brand-coral">Beranda</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="ml-1 md:ml-2 hover:text-brand-coral">{{ $product->category->name }}</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="ml-1 md:ml-2 text-gray-800 font-medium line-clamp-1">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-0">
            
            <!-- Product Images (Left side) -->
            <div class="lg:col-span-2 p-6 md:p-8 bg-gray-50 border-r border-gray-100" x-data="{ mainImage: '{{ $product->main_image ? Storage::url($product->main_image) : '' }}' }">
                <!-- Main Image -->
                <div class="aspect-square bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 flex items-center justify-center relative">
                    @if($product->main_image)
                        <img :src="mainImage" alt="{{ $product->name }}" class="w-full h-full object-contain">
                    @else
                        <div class="text-gray-400 flex flex-col items-center">
                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Tidak ada gambar</span>
                        </div>
                    @endif
                    
                    @if($product->stock <= 0)
                        <div class="absolute inset-0 bg-white/70 backdrop-blur-sm flex items-center justify-center">
                            <span class="px-6 py-2 bg-red-600 font-bold text-white text-xl rounded-lg shadow-lg rotate-12">SOLD OUT</span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnails -->
                @if($product->images && count($product->images) > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images as $image)
                    <button @click="mainImage = '{{ Storage::url($image) }}'" type="button" class="aspect-square bg-white rounded-lg border-2 border-transparent hover:border-brand-coral focus:border-brand-coral focus:outline-none overflow-hidden transition-all">
                        <img src="{{ Storage::url($image) }}" alt="Thumbnail" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Details (Right side) -->
            <div class="lg:col-span-3 p-6 md:p-8 flex flex-col">
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-coral">{{ $product->category->name }}</span>
                    <span class="text-sm text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        {{ $product->views }} views
                    </span>
                </div>
                
                <h1 class="text-3xl font-serif font-bold text-brand-navy mb-4">{{ $product->name }}</h1>
                
                <div class="flex items-end gap-4 mb-6 pb-6 border-b border-gray-100">
                    <p class="text-4xl font-bold text-brand-navy tracking-tight">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                <div class="grid grid-cols-2 gap-y-4 gap-x-8 mb-8">
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-medium">Kondisi</p>
                        <p class="text-base font-semibold text-gray-900">{{ $product->condition_label }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-medium">Ukuran</p>
                        <p class="text-base font-semibold text-gray-900">{{ $product->size ?? 'Tidak spesifik' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-medium">Brand</p>
                        <p class="text-base font-semibold text-gray-900">{{ $product->brand ?? 'Tidak bermerk' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-medium">Stok</p>
                        <p class="text-base font-semibold text-gray-900">{{ $product->stock }} item</p>
                    </div>
                </div>

                <div class="mb-8 flex-grow">
                    <h3 class="text-lg font-bold text-brand-navy mb-3">Deskripsi Produk</h3>
                    <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 mt-auto">
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="w-full flex justify-center items-center px-8 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-brand-coral hover:bg-red-500 hover:shadow-lg hover:-translate-y-0.5 transition-all shadow-brand-coral/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <button type="button" disabled class="flex-1 flex justify-center items-center px-8 py-4 border border-transparent text-base font-bold rounded-xl text-gray-500 bg-gray-200 cursor-not-allowed">
                            Stok Habis
                        </button>
                    @endif

                    <form action="{{ route('wishlists.toggle', $product) }}" method="POST" class="sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full sm:w-16 h-14 flex justify-center items-center border border-gray-300 rounded-xl bg-white text-gray-500 hover:text-brand-coral hover:bg-red-50 hover:border-red-200 transition-colors shadow-sm">
                            <svg class="h-6 w-6 {{ $inWishlist ? 'fill-brand-coral text-brand-coral' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </form>
                </div>

                <!-- Seller Info -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-brand-navy flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        {{ substr($product->seller->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 mb-0.5">Dijual oleh</p>
                        <p class="font-bold text-brand-navy">{{ $product->seller->name ?? 'Anonim' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($related->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-serif font-bold text-brand-navy mb-6">Produk Serupa</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $rel)
                <x-product-card :product="$rel" />
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
