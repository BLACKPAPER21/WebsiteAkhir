@props(['product'])

<div class="group relative flex flex-col bg-transparent group-hover:z-10 h-full">
    <!-- Image Area with Glassmorphism Hover Overlay -->
    <a href="{{ route('products.show', $product->slug) }}" class="block relative w-full aspect-[3/4] rounded-2xl overflow-hidden bg-gray-100 shadow-sm border border-black/5 transform transition-transform duration-500 ease-out group-hover:-translate-y-2 group-hover:shadow-[0_20px_40px_-15px_rgba(26,26,46,0.15)]">
        @if($product->main_image)
            <img src="{{ Storage::url($product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] group-hover:scale-110">
        @else
            <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 bg-gray-50/50">
                <svg class="w-10 h-10 mb-2 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
        
        <!-- Gradient Overlay on Hover -->
        <div class="absolute inset-0 bg-gradient-to-t from-brand-navy/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <!-- Condition Badge -->
        <div class="absolute top-4 left-4">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase bg-white/90 text-brand-navy backdrop-blur-md shadow-sm border border-white/20">
                {{ $product->condition_label }}
            </span>
        </div>
        
        <!-- Shop Name Badge on Hover (jika ada) -->
        @if($product->seller && $product->seller->shop_name)
        <div class="absolute top-4 right-4 transform translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-brand-coral/90 backdrop-blur-md text-white text-[10px] font-bold shadow-sm">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                {{ $product->seller->shop_name }}
            </span>
        </div>
        @endif

        <!-- Size Badge inside Hover State -->
        @if($product->size)
        <div class="absolute bottom-4 left-4 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 delay-75">
            <span class="inline-flex items-center justify-center h-8 px-3 rounded-full bg-brand-navy/80 backdrop-blur-md text-white text-xs font-semibold shadow-sm border border-white/10">
                Ukuran: {{ $product->size }}
            </span>
        </div>
        @endif
    </a>
    
    <!-- Info Area -->
    <div class="pt-5 pb-2 px-1 flex flex-col flex-grow">
        <div class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-1 flex justify-between items-center">
            <span>{{ $product->category->name }}</span>
            <span class="flex items-center text-gray-400"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> {{ $product->views }}</span>
        </div>

        {{-- Nama Toko Mitra --}}
        @if($product->seller && $product->seller->shop_name)
        <div class="flex items-center gap-1 mb-2">
            <svg class="w-3 h-3 text-brand-coral flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <span class="text-[10px] font-semibold text-brand-coral truncate">{{ $product->seller->shop_name }}</span>
        </div>
        @endif
        
        <h3 class="text-base font-serif font-bold text-brand-navy group-hover:text-brand-coral transition-colors line-clamp-2 leading-relaxed mb-auto">
            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
        </h3>
        
        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-lg font-bold text-gray-900 tracking-tight">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            
            <form action="{{ route('wishlists.toggle', $product) }}" method="POST" class="inline-flex">
                @csrf
                <button type="submit" class="p-1.5 rounded-full hover:bg-red-50 text-gray-300 hover:text-brand-coral focus:outline-none transition-colors group/btn" title="Tambah ke Wishlist">
                    <svg class="h-6 w-6 {{ auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'fill-brand-coral text-brand-coral' : 'group-hover/btn:scale-110 transition-transform' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
