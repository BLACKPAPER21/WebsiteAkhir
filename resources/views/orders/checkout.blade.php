@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-serif font-bold text-brand-navy mb-8">Checkout</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Form Checkout -->
        <div class="flex-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex items-center">
                    <span class="w-8 h-8 rounded-full bg-brand-navy text-white font-bold flex items-center justify-center mr-3">1</span>
                    <h2 class="text-lg font-bold text-brand-navy mt-1">Alamat Pengiriman</h2>
                </div>
                
                <form id="checkout-form" action="{{ route('orders.store') }}" method="POST" class="p-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label>
                            <input type="text" name="recipient_name" id="recipient_name" value="{{ auth()->user()->name }}" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-coral focus:ring focus:ring-brand-coral focus:ring-opacity-50 h-11 px-4">
                            @error('recipient_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="recipient_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="text" name="recipient_phone" id="recipient_phone" value="{{ auth()->user()->phone }}" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-coral focus:ring focus:ring-brand-coral focus:ring-opacity-50 h-11 px-4">
                            @error('recipient_phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-coral focus:ring focus:ring-brand-coral focus:ring-opacity-50 p-4">{{ auth()->user()->address }}</textarea>
                        @error('shipping_address') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan untuk Penjual (Opsional)</label>
                        <textarea name="notes" id="notes" rows="2" placeholder="Contoh: Tolong packing dengan aman ya."
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-coral focus:ring focus:ring-brand-coral focus:ring-opacity-50 p-4"></textarea>
                    </div>

                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex items-center">
                    <span class="w-8 h-8 rounded-full bg-brand-navy text-white font-bold flex items-center justify-center mr-3">2</span>
                    <h2 class="text-lg font-bold text-brand-navy mt-1">Metode Pembayaran</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative border rounded-lg p-4 flex cursor-pointer hover:bg-gray-50 border-gray-200">
                            <input type="radio" name="payment_method" value="bank_transfer" class="sr-only" form="checkout-form" checked onchange="document.querySelectorAll('.payment-border').forEach(e => e.classList.remove('border-brand-coral', 'bg-red-50')); this.parentNode.classList.add('border-brand-coral', 'bg-red-50');">
                            <div class="flex flex-col items-center justify-center w-full payment-border border-transparent rounded-lg">
                                <svg class="w-8 h-8 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                <span class="font-medium text-brand-navy text-center">Transfer Bank</span>
                            </div>
                        </label>
                        
                        <label class="relative border rounded-lg p-4 flex cursor-pointer hover:bg-gray-50 border-gray-200">
                            <input type="radio" name="payment_method" value="e_wallet" class="sr-only" form="checkout-form" onchange="document.querySelectorAll('.payment-border').forEach(e => e.classList.remove('border-brand-coral', 'bg-red-50')); this.parentNode.classList.add('border-brand-coral', 'bg-red-50');">
                            <div class="flex flex-col items-center justify-center w-full payment-border border-transparent rounded-lg">
                                <svg class="w-8 h-8 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="font-medium text-brand-navy text-center">E-Wallet</span>
                            </div>
                        </label>

                        <label class="relative border border-brand-coral bg-red-50 rounded-lg p-4 flex cursor-pointer hover:bg-red-50/80">
                            <input type="radio" name="payment_method" value="cod" class="sr-only" form="checkout-form" onchange="document.querySelectorAll('.payment-border').forEach(e => e.classList.remove('border-brand-coral', 'bg-red-50')); this.parentNode.classList.add('border-brand-coral', 'bg-red-50');">
                            <div class="flex flex-col items-center justify-center w-full payment-border rounded-lg">
                                <svg class="w-8 h-8 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                <span class="font-medium text-brand-navy text-center">Bayar di Tempat (COD)</span>
                            </div>
                        </label>
                    </div>
                    @error('payment_method') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:w-[400px] flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h2 class="text-lg font-bold text-brand-navy mb-4 border-b border-gray-100 pb-4">Pesanan Anda</h2>
                
                <ul class="divide-y divide-gray-100 mb-6 max-h-96 overflow-y-auto pr-2">
                    @foreach($cart->items as $item)
                    <li class="py-4 flex">
                        <div class="w-16 h-16 flex-shrink-0 rounded-md border border-gray-200 overflow-hidden">
                            @if($item->product->main_image)
                                <img src="{{ Storage::url($item->product->main_image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="ml-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="text-sm text-gray-900 font-medium line-clamp-2">{{ $item->product->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $item->product->condition_label }} | {{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-bold text-brand-navy mt-1">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
                
                <div class="space-y-3 mb-6 font-medium">
                    <div class="flex justify-between text-gray-600 text-sm">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 text-sm">
                        <span>Biaya Pengiriman</span>
                        <span>Rp 25.000</span>
                    </div>
                    <div class="flex justify-between text-gray-600 text-sm">
                        <span>Biaya Layanan</span>
                        <span>Rp 2.500</span>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4 mb-6 flex justify-between items-center">
                    <span class="text-base font-bold text-brand-navy">Total Pembayaran</span>
                    <span class="text-xl font-bold text-brand-coral">Rp {{ number_format($cart->total + 27500, 0, ',', '.') }}</span>
                </div>
                
                <button type="submit" form="checkout-form" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-brand-coral hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors shadow-brand-coral/30">
                    Buat Pesanan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
