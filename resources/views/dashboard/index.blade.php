@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar Dashboard -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 bg-brand-navy text-white text-center">
                    <div class="w-20 h-20 rounded-full bg-white text-brand-navy flex items-center justify-center font-bold text-3xl mx-auto mb-4">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <h3 class="font-bold text-lg">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-400">{{ auth()->user()->email }}</p>
                </div>
                <div class="p-2">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg font-medium {{ request()->routeIs('dashboard') ? 'bg-red-50 text-brand-coral' : 'text-gray-700 hover:bg-gray-50' }}">
                        Riwayat Pesanan
                    </a>
                    <a href="{{ route('wishlists.index') }}" class="block px-4 py-3 rounded-lg font-medium {{ request()->routeIs('wishlists.index') ? 'bg-red-50 text-brand-coral' : 'text-gray-700 hover:bg-gray-50' }}">
                        Wishlist Saya
                    </a>
                    <!-- Additional links to Edit Profile can be added here -->
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
            
            <!-- Partner CTA Banner -->
            @if(!auth()->user()->isSeller())
                @php
                    $existingApp = \App\Models\SellerApplication::where('user_id', auth()->id())->first();
                @endphp
                
                @if(!$existingApp || $existingApp->status === 'rejected')
                    <div class="mb-8 relative overflow-hidden rounded-2xl bg-brand-navy p-6 md:p-8 shadow-xl text-white">
                        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                        <div class="absolute -right-20 -top-20 w-64 h-64 bg-brand-coral rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-pulse"></div>
                        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
                            <div>
                                <h3 class="text-xl md:text-2xl font-serif font-bold mb-2">Jadilah Demplane Curator</h3>
                                <p class="text-gray-300 text-xs md:text-sm max-w-lg">Punya koleksi fashion preloved premium yang sudah tak terpakai? Bergabunglah sebagai mitra penjual dan temukan pembeli yang tepat untuk barang berharga Anda.</p>
                            </div>
                            <a href="{{ route('partner.index') }}" class="w-full md:w-auto flex-shrink-0 px-6 py-3 bg-white text-brand-navy text-sm font-bold tracking-widest uppercase rounded-full hover:bg-brand-coral hover:text-white transition-colors shadow-lg text-center">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                @elseif($existingApp->status === 'pending')
                    <div class="mb-8 bg-blue-50 border border-blue-200 rounded-2xl p-6 flex items-start">
                        <svg class="w-6 h-6 text-blue-500 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <h4 class="font-bold text-blue-900 mb-1">Aplikasi Mitra Sedang Ditinjau</h4>
                            <p class="text-sm text-blue-700">Terima kasih telah mendaftar sebagai Demplane Curator. Tim kami sedang memverifikasi dokumen Anda (Toko: {{ $existingApp->shop_name }}). Harap bersabar menunggu persetujuan maksimal 1-2 hari kerja.</p>
                        </div>
                    </div>
                @endif
            @endif

            <h1 class="text-2xl font-serif font-bold text-brand-navy mb-6">Riwayat Pesanan</h1>
            
            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Tanggal Pesanan: <span class="font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</span></p>
                                    <p class="text-sm text-gray-500">No. Invoice: <span class="font-bold text-brand-navy">{{ $order->order_number }}</span></p>
                                </div>
                                
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif
                                    ">
                                        {{ $order->status_label }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                @foreach($order->items as $item)
                                    <div class="flex items-center py-4 border-b border-gray-50 last:border-0 last:pb-0">
                                        <div class="w-20 h-20 rounded-md border border-gray-200 overflow-hidden flex-shrink-0">
                                            @if($item->product->main_image)
                                                <img src="{{ Storage::url($item->product->main_image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <a href="{{ route('products.show', $item->product->slug) }}" class="text-base font-medium text-brand-navy hover:text-brand-coral">{{ $item->product->name }}</a>
                                            <p class="text-sm text-gray-500 mt-1">{{ $item->quantity }} barang x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-right ml-4">
                                            <p class="text-base font-bold text-brand-navy">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <p class="text-sm text-gray-600">Total Pesanan: <span class="text-lg font-bold text-brand-coral ml-2">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
                                
                                <!-- TBD Action button like 'Track' or 'Pay' depending on status -->
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl p-12 text-center border border-dashed border-gray-300">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
                    <p class="text-gray-500 mb-6 max-w-sm mx-auto">Anda belum pernah melakukan pembelian. Yuk mulai cari barang preloved impianmu!</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-brand-coral text-white font-medium rounded-lg hover:bg-red-500 transition-colors">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
