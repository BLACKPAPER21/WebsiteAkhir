@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sticky top-24">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-brand-navy flex items-center">
                        <svg class="w-5 h-5 mr-2 text-brand-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </h2>
                    <a href="{{ route('products.index') }}" class="text-xs font-medium text-gray-500 hover:text-brand-coral">Reset</a>
                </div>
                
                <form action="{{ route('products.index') }}" method="GET" x-data="{ openCategory: true, openCondition: true, openPrice: true }">
                    <!-- Keep search term -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <!-- Keep sorting -->
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <!-- Category Filter -->
                    <div class="mb-6">
                        <button type="button" @click="openCategory = !openCategory" class="flex justify-between items-center w-full text-left font-semibold text-gray-800 mb-3 focus:outline-none">
                            Kategori
                            <svg :class="{'rotate-180': openCategory}" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openCategory" class="space-y-2">
                            @foreach($categories as $category)
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="category" value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'checked' : '' }} class="form-radio text-brand-coral focus:ring-brand-coral mr-3" onchange="this.form.submit()">
                                <span class="text-sm text-gray-600 group-hover:text-brand-navy">{{ $category->name }} ({{ $category->products_count }})</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Condition Filter -->
                    <div class="mb-6">
                        <button type="button" @click="openCondition = !openCondition" class="flex justify-between items-center w-full text-left font-semibold text-gray-800 mb-3 focus:outline-none">
                            Kondisi
                            <svg :class="{'rotate-180': openCondition}" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openCondition" class="space-y-2">
                            @php $conditions = ['brand_new' => 'Baru', 'like_new' => 'Seperti Baru', 'good' => 'Baik', 'fair' => 'Cukup']; @endphp
                            @foreach($conditions as $val => $label)
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="condition" value="{{ $val }}" {{ request('condition') == $val ? 'checked' : '' }} class="form-radio text-brand-coral focus:ring-brand-coral mr-3" onchange="this.form.submit()">
                                <span class="text-sm text-gray-600 group-hover:text-brand-navy">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header & Sorting -->
            <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 gap-4">
                <div>
                    <h1 class="text-xl font-bold text-brand-navy">
                        @if(request('search'))
                            Hasil pencarian untuk "<span class="text-brand-coral">{{ request('search') }}</span>"
                        @elseif(request('category'))
                            Produk Kategori {{ $categories->where('slug', request('category'))->first()->name ?? '' }}
                        @else
                            Semua Produk
                        @endif
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk</p>
                </div>

                <div class="flex items-center">
                    <label for="sort" class="text-sm font-medium border border-gray-200">Urutkan:</label>
                    <select onchange="window.location.href=this.value" class="ml-2 border-gray-300 rounded-md text-sm focus:ring-brand-coral focus:border-brand-coral p-2">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                    </select>
                </div>
            </div>

            <!-- Product Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl p-12 text-center border border-dashed border-gray-300 flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada produk ditemukan</h3>
                    <p class="text-gray-500 mb-6 max-w-sm">Maaf, kami tidak dapat menemukan produk yang sesuai dengan kriteria filter Anda.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-brand-navy text-white text-sm font-medium rounded-md hover:bg-gray-800 transition-colors">
                        Hapus Semua Filter
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
