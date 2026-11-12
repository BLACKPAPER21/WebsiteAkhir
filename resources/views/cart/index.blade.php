@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-serif font-bold text-brand-navy mb-8">Keranjang Belanja</h1>

    @if($cart && $cart->items->count() > 0)
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <ul class="divide-y divide-gray-100">
                        @foreach($cart->items as $item)
                        <li class="p-6 flex flex-col sm:flex-row items-start sm:items-center gap-6">
                            <a href="{{ route('products.show', $item->product->slug) }}" class="flex-shrink-0 w-24 h-24 bg-gray-50 rounded-lg overflow-hidden border border-gray-100">
                                @if($item->product->main_image)
                                    <img src="{{ Storage::url($item->product->main_image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="flex-1 w-full sm:w-auto">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 leading-tight">
                                            <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-brand-coral">{{ $item->product->name }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $item->product->category->name }} &bull; {{ $item->product->condition_label }}</p>
                                    </div>
                                    <p class="text-lg font-bold text-brand-navy">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-600 mr-3 hidden sm:inline">Jumlah:</span>
                                        <div class="flex items-center border border-gray-300 rounded-md">
                                            <!-- Preloved Usually 1 quantity -->
                                            <span class="px-4 py-1 text-sm font-medium text-gray-700 bg-gray-50">{{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                    
                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-96 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-brand-navy mb-4 border-b border-gray-100 pb-4">Ringkasan Belanja</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Harga ({{ $cart->items->sum('quantity') }} barang)</span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Estimasi Ongkos Kirim</span>
                            <span class="font-medium text-gray-800">Dihitung saat checkout</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-4 mb-6 flex justify-between items-center">
                        <span class="text-base font-bold text-brand-navy">Total Belanja</span>
                        <span class="text-xl font-bold text-brand-coral">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                    </div>
                    
                    <a href="{{ route('orders.checkout') }}" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-brand-navy hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors">
                        Beli Sekarang ({{ $cart->items->sum('quantity') }})
                    </a>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('products.index') }}" class="text-sm text-brand-coral font-medium hover:underline">
                            Lanjut Belanja 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm flex flex-col items-center">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-brand-navy mb-2">Keranjang belanja Anda kosong</h2>
            <p class="text-gray-500 mb-8 max-w-md">Temukan fashion preloved berkualitas premium yang siap memperbarui gaya Anda tanpa merusak lingkungan.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-brand-coral text-white font-medium rounded-lg hover:bg-red-500 transition-colors shadow-sm">
                Mulai Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
