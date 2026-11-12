@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12 text-center">
        <!-- Success Icon -->
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        
        <h1 class="text-3xl font-serif font-bold text-brand-navy mb-4">Pesanan Berhasil Dibuat!</h1>
        <p class="text-gray-600 mb-8 max-w-lg mx-auto">Terima kasih telah berbelanja di Demplane. Pesanan Anda dengan nomor <span class="font-bold text-brand-navy">#{{ $order->order_number }}</span> telah berhasil kami terima.</p>
        
        <div class="bg-gray-50 rounded-xl p-6 text-left mb-8 max-w-md mx-auto border border-gray-100">
            <h3 class="font-bold text-brand-navy mb-4">Detail Ringkas</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Pesanan:</span>
                    <span class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Total Pembayaran:</span>
                    <span class="font-bold text-brand-coral">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Metode Pembayaran:</span>
                    <span class="font-medium capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-brand-navy hover:bg-gray-800 transition-colors">
                Lihat Pesanan Saya
            </a>
            <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
