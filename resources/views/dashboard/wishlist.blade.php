@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar Dashboard -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <!-- (Sama dengan sidebar yg ada di dashboard/index.blade.php) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 bg-brand-navy text-white text-center">
                    <div class="w-20 h-20 rounded-full bg-white text-brand-navy flex items-center justify-center font-bold text-3xl mx-auto mb-4">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <h3 class="font-bold text-lg">{{ auth()->user()->name }}</h3>
                </div>
                <div class="p-2">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg font-medium {{ request()->routeIs('dashboard') ? 'bg-red-50 text-brand-coral' : 'text-gray-700 hover:bg-gray-50' }}">
                        Riwayat Pesanan
                    </a>
                    <a href="{{ route('wishlists.index') }}" class="block px-4 py-3 rounded-lg font-medium {{ request()->routeIs('wishlists.index') ? 'bg-red-50 text-brand-coral' : 'text-gray-700 hover:bg-gray-50' }}">
                        Wishlist Saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4 border-t border-gray-100 pt-2">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-lg font-medium text-red-600 hover:bg-red-50 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <h1 class="text-2xl font-serif font-bold text-brand-navy mb-6">Wishlist Saya</h1>
            
            @if($wishlists->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($wishlists as $wishlist)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all flex flex-col h-full group">
                            <a href="{{ route('products.show', $wishlist->product->slug) }}" class="block relative aspect-[4/5] bg-gray-100">
                                @if($wishlist->product->main_image)
                                    <img src="{{ Storage::url($wishlist->product->main_image) }}" alt="{{ $wishlist->product->name }}" class="w-full h-full object-cover">
                                @endif
                                
                                <form action="{{ route('wishlists.toggle', $wishlist->product) }}" method="POST" class="absolute top-2 right-2">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-brand-coral hover:bg-red-50" title="Hapus dari Wishlist">
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </button>
                                </form>
                            </a>
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="text-base font-medium text-gray-900 line-clamp-2 mb-2"><a href="{{ route('products.show', $wishlist->product->slug) }}">{{ $wishlist->product->name }}</a></h3>
                                <p class="text-lg font-bold text-brand-coral mt-auto">Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}</p>
                                
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                                    <button type="submit" class="w-full py-2 bg-brand-navy text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">Tambah ke Keranjang</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl p-12 text-center border border-dashed border-gray-300">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Wishlist kosong</h3>
                    <p class="text-gray-500 mb-6 max-w-sm mx-auto">Anda belum menyimpan produk apapun ke dalam wishlist.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-brand-navy text-white font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        Jelajahi Produk
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
