@extends('layouts.admin')

@section('header', 'Detail Pesanan')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-gray-500 hover:text-brand-coral inline-flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Pesanan
    </a>
</div>

<div class="flex flex-col xl:flex-row gap-6">
    <!-- Main Detail -->
    <div class="flex-1 space-y-6">
        
        <!-- Header Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-1">Pesanan #{{ $order->order_number }}</h2>
                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            
            <div class="flex flex-col items-end">
                <span class="mb-2 px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                    @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ $order->status_label }}
                </span>
                
                @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center">
                    @csrf
                    @method('PUT')
                    <select name="status" class="text-sm border-gray-300 rounded-lg shadow-sm focus:border-brand-coral focus:ring focus:ring-brand-coral focus:ring-opacity-50 h-9 py-0 pl-3 pr-8">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="ml-2 px-3 py-1.5 bg-brand-navy text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">Update</button>
                </form>
                @endif
            </div>
        </div>

        <!-- Products List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900">Produk yang Dipesan</h3>
            </div>
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="pb-3 font-medium">Produk</th>
                            <th class="pb-3 font-medium text-center">Harga</th>
                            <th class="pb-3 font-medium text-center">Qty</th>
                            <th class="pb-3 font-medium text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded border border-gray-200 overflow-hidden flex-shrink-0">
                                        @if($item->product->main_image)
                                            <img src="{{ Storage::url($item->product->main_image) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="font-medium text-brand-navy hover:underline" target="_blank">{{ $item->product->name }}</a>
                                        <p class="text-xs text-gray-500 mt-1">Kondisi: {{ $item->product->condition_label }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="py-4 text-center font-medium">{{ $item->quantity }}</td>
                            <td class="py-4 text-right font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t border-gray-200 font-medium">
                        <tr>
                            <td colspan="3" class="py-4 text-right text-gray-500">Subtotal</td>
                            <td class="py-4 text-right">Rp {{ number_format($order->total_price - 27500, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-2 text-right text-gray-500">Ongkos Kirim</td>
                            <td class="py-2 text-right">Rp 25.000</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-2 text-right text-gray-500">Biaya Layanan</td>
                            <td class="py-2 text-right border-b border-gray-100 pb-4">Rp 2.500</td>
                        </tr>
                        <tr class="text-lg">
                            <td colspan="3" class="py-4 text-right font-bold text-gray-900">Total</td>
                            <td class="py-4 text-right font-bold text-brand-coral">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="xl:w-80 flex-shrink-0 space-y-6">
        
        <!-- Customer Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900">Informasi Pelanggan</h3>
            </div>
            <div class="p-5 flex items-center">
                <div class="w-12 h-12 rounded-full bg-brand-navy text-white flex items-center justify-center font-bold text-xl">
                    {{ substr($order->user->name, 0, 1) }}
                </div>
                <div class="ml-4">
                    <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    <p class="text-sm text-gray-500">{{ $order->user->phone ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900">Informasi Pengiriman</h3>
            </div>
            <div class="p-5">
                <div class="mb-4">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Penerima</p>
                    <p class="font-medium text-gray-900">{{ $order->shipping_address['recipient_name'] ?? $order->user->name }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nomor Telepon</p>
                    <p class="text-gray-900">{{ $order->shipping_address['recipient_phone'] ?? $order->user->phone }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Alamat Pengiriman</p>
                    <p class="text-gray-900 font-medium leading-relaxed">
                        {{ $order->shipping_address['address'] ?? $order->user->address }}
                    </p>
                </div>
                @if(!empty($order->notes))
                <div class="mt-4 p-3 bg-yellow-50 rounded-lg text-sm text-yellow-800">
                    <span class="font-bold block mb-1">Catatan Pembeli:</span>
                    {{ $order->notes }}
                </div>
                @endif
            </div>
        </div>

        <!-- Payment Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900">Informasi Pembayaran</h3>
            </div>
            <div class="p-5">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Metode</p>
                <div class="flex items-center">
                    <p class="font-bold text-brand-navy capitalize mr-2">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                    @if($order->payment_status === 'paid')
                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Lunas</span>
                    @else
                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
