@extends('layouts.app')

@section('content')
<!-- Super Modern Hero Section 2026 -->
<div class="relative min-h-[92vh] flex items-center bg-brand-light overflow-hidden pt-20">
    <!-- Abstract 3D Blur Balls -->
    <div class="absolute top-0 right-0 -mr-32 -mt-32 w-[500px] h-[500px] rounded-full bg-brand-coral/10 blur-[100px] animate-pulse pointer-events-none"></div>
    <div class="absolute bottom-20 left-10 w-[400px] h-[400px] rounded-full bg-brand-navy/10 blur-[120px] pointer-events-none"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Typography -->
            <div class="lg:col-span-6 lg:pr-10" data-aos="fade-right" data-aos-duration="1000">
                <div class="inline-flex items-center gap-3 py-1.5 px-4 rounded-full bg-brand-navy/5 border border-brand-navy/10 text-brand-navy text-xs font-bold tracking-[0.2em] uppercase mb-8 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-brand-coral animate-ping"></span>
                    <span>Era Baru Fashion Fungsional</span>
                </div>
                
                <h1 class="text-5xl sm:text-7xl lg:text-[5.5rem] font-serif font-extrabold text-brand-navy leading-[1.05] tracking-tight mb-6 md:mb-8">
                    Curated <br/>
                    <span class="relative inline-block">
                        <span class="relative z-10 italic font-light">Preloved</span>
                        <!-- Custom Underline -->
                        <span class="absolute bottom-2 md:bottom-4 left-0 w-full h-2 md:h-3 bg-brand-coral/30 -z-10 -rotate-2"></span>
                    </span> <br/>
                    Fashion.
                </h1>
                
                <p class="text-base sm:text-xl text-gray-500 mb-8 md:mb-12 leading-relaxed font-light max-w-lg border-l-2 border-brand-coral pl-4 md:pl-6">
                    Mendefinisikan ulang kemewahan tanpa limbah. Kurasi arsip pakaian ikonik untuk gaya hidup modern yang sadar lingkungan.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-5">
                    <a href="{{ route('products.index') }}" class="group relative inline-flex justify-center items-center px-8 md:px-10 py-4 md:py-5 text-xs md:text-sm font-bold uppercase tracking-widest rounded-full text-brand-light bg-brand-navy overflow-hidden shadow-2xl transition-all duration-500 hover:shadow-brand-navy/40 hover:-translate-y-1 w-full sm:w-auto">
                        <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-brand-coral rounded-full group-hover:w-72 group-hover:h-56 opacity-10"></span>
                        <span class="relative flex items-center">Mulai Eksplorasi <svg class="w-4 h-4 ml-3 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></span>
                    </a>
                </div>
            </div>
            
            <!-- Right Asymmetric Image Showcase -->
            <div class="lg:col-span-6 relative h-[600px] mt-10 lg:mt-0" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
                <!-- Main Image Card -->
                <div class="absolute right-0 top-0 w-4/5 h-[500px] rounded-[2rem] overflow-hidden shadow-2xl z-20 group">
                    <div class="absolute inset-0 bg-brand-navy/20 mix-blend-multiply z-10 group-hover:bg-transparent transition-colors duration-700"></div>
                    <img src="{{ asset('images/hero_main.jpg') }}" alt="High End Fashion" class="w-full h-full object-cover scale-105 group-hover:scale-100 transition-transform duration-[1.5s] ease-out">
                    
                    <!-- Glassmorphism badge inside image -->
                    <div class="absolute bottom-6 left-6 z-20 bg-white/10 backdrop-blur-md border border-white/20 px-6 py-4 rounded-2xl flex items-center gap-4 animate-float">
                        <div class="w-12 h-12 rounded-full bg-brand-coral/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <div>
                            <p class="text-white font-serif font-bold text-lg">Premium Quality</p>
                            <p class="text-white/70 text-sm">Authenticity Guaranteed</p>
                        </div>
                    </div>
                </div>
                
                <!-- Secondary Overlapping Image -->
                <div class="absolute left-0 bottom-0 w-2/5 h-[320px] rounded-[1.5rem] overflow-hidden shadow-2xl z-30 border-[6px] border-brand-light transform -translate-y-10 hover:-translate-y-16 transition-transform duration-700 ease-out animate-float" style="animation-delay: 1s;">
                    <img src="{{ asset('images/hero_secondary.jpg') }}" alt="Details" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Infinite Brand Marquee -->
<div class="bg-brand-navy py-5 overflow-hidden border-y border-white/10 relative flex items-center">
    <div class="flex whitespace-nowrap animate-marquee">
        <!-- Text Group (Repeated for infinite effect) -->
        @for($i = 0; $i < 6; $i++)
        <div class="flex items-center text-brand-light opacity-80 mix-blend-screen px-4">
            <span class="text-xl md:text-2xl font-serif font-bold italic mr-8">Circular Fashion</span>
            <span class="w-2 h-2 bg-brand-coral rounded-full mr-8"></span>
            <span class="text-xl md:text-2xl font-sans tracking-widest font-semibold uppercase mr-8">Authentic</span>
            <span class="w-2 h-2 bg-brand-coral rounded-full mr-8"></span>
            <span class="text-xl md:text-2xl font-serif font-bold italic mr-8">Sustainable</span>
            <span class="w-2 h-2 bg-brand-coral rounded-full mr-8"></span>
            <span class="text-xl md:text-2xl font-sans tracking-widest font-semibold uppercase mr-8">Premium</span>
            <span class="w-2 h-2 bg-brand-coral rounded-full mr-8"></span>
        </div>
        @endfor
    </div>
</div>

<!-- Category Showroom -->
<div class="bg-white py-32 relative overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full max-w-7xl">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-brand-light rounded-full blur-3xl opacity-50"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16" data-aos="fade-up">
            <div class="max-w-xl">
                <span class="text-brand-coral text-sm font-bold tracking-[0.2em] uppercase mb-4 block">Manifesto Demplane</span>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-brand-navy mb-4">Ruang Kurasi</h2>
                <p class="text-gray-500 text-lg">Berdasarkan siluet dan potongan estetika yang membentuk identitas Anda.</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories->take(4) as $index => $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                   class="group relative h-[400px] md:h-[500px] rounded-3xl overflow-hidden block"
                   data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                   
                    <div class="absolute inset-0 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-{{ $index === 0 ? '1489987701169-43049b7ce26a' : ($index === 1 ? '1543163521-1bf539c55dd2' : ($index === 2 ? '1515886657613-9f3515b0c78f' : '1490481651871-ab68de25d43d')) }}?q=80&w=800&auto=format&fit=crop" 
                             alt="{{ $category->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 group-hover:rotate-1 filter grayscale-[30%] group-hover:grayscale-0 transition-all duration-[1.5s] ease-out">
                    </div>
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-navy/80 via-transparent to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="absolute bottom-0 left-0 w-full p-8 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <div class="flex justify-between items-end">
                            <div>
                                <h3 class="text-3xl font-serif font-bold text-white mb-2">{{ $category->name }}</h3>
                                <p class="text-brand-light/80 text-sm font-medium tracking-widest uppercase">{{ $category->products_count }} ITEMS</p>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-500 delay-100">
                                <svg class="w-5 h-5 text-white transform -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Latest Drop Scrolling Concept -->
<div class="py-32 bg-brand-light relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-16" data-aos="fade-up">
            <div>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-brand-navy mb-4">Latest Arrival</h2>
                <div class="h-1 w-24 bg-brand-coral"></div>
            </div>
            <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="hidden sm:inline-flex items-center text-sm font-bold tracking-widest uppercase text-brand-navy hover:text-brand-coral group">
                Lihat Katalog
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
            @forelse($latestProducts as $index => $product)
                <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-gray-400 text-lg">Belum ada rilis produk terbaru.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-16 text-center sm:hidden">
            <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="inline-flex justify-center items-center px-8 py-4 bg-white border border-gray-200 text-sm font-bold uppercase tracking-widest rounded-full text-brand-navy w-full shadow-sm">
                Lihat Semua Koleksi
            </a>
        </div>
    </div>
</div>

<!-- Partner CTA Banner -->
<div class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-3xl md:rounded-[2.5rem] bg-brand-navy overflow-hidden shadow-2xl p-8 md:p-16 lg:p-20 text-center md:text-left" data-aos="fade-up">
            <!-- Background Elements -->
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
            <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-brand-coral rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-pulse"></div>
            
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-brand-coral text-xs md:text-sm font-bold tracking-[0.2em] uppercase mb-4 block">Demplane Curator</span>
                    <h2 class="text-3xl md:text-5xl font-serif font-bold text-white mb-6 leading-tight">
                        Punya Koleksi Fesyen yang Sudah Tak Terpakai?
                    </h2>
                    <p class="text-gray-300 text-base md:text-lg mb-8 leading-relaxed max-w-lg font-light mx-auto md:mx-0">
                        Jadilah mitra penjualan kami. Jangkau komunitas pencinta fashion premium, kurasi lemari Anda, dan berikan ruang untuk gaya baru.
                    </p>
                    <a href="{{ route('partner.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-brand-navy text-xs md:text-sm font-bold tracking-widest uppercase rounded-full hover:bg-brand-coral hover:text-white transition-all duration-300 shadow-xl hover:-translate-y-1 w-full md:w-auto">
                        Daftar Menjadi Mitra
                    </a>
                </div>
                <div class="hidden md:block relative h-full min-h-[300px]">
                    <div class="absolute inset-0 border-4 border-white/10 rounded-2xl transform rotate-3"></div>
                    <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=800&auto=format&fit=crop" alt="Fashion Wardrobe" class="absolute inset-0 w-full h-full object-cover rounded-2xl transform -rotate-2 shadow-2xl hover:rotate-0 transition-transform duration-500">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Manifesto Section -->
<div class="py-32 bg-brand-navy text-center px-4 relative overflow-hidden">
    <!-- Geometric Accents -->
    <div class="absolute top-0 right-[20%] w-[1px] h-full bg-white/5"></div>
    <div class="absolute top-0 left-[20%] w-[1px] h-full bg-white/5"></div>
    <div class="absolute top-1/2 left-0 w-full h-[1px] bg-white/5 -translate-y-1/2"></div>
    
    <div class="relative max-w-4xl mx-auto z-10" data-aos="zoom-in" data-aos-duration="1000">
        <svg class="w-16 h-16 text-brand-coral mx-auto mb-8 opacity-80" fill="currentColor" viewBox="0 0 24 24"><path d="M11.99 22.01L12 22l-.01.01zM11.96 1L3 8h2v13h4v-6h6v6h4V8h2l-8.96-7h-.08zm.05 4.54l5.35 4.2h-1.35v11h-2v-6H10v6H8v-11H6.66l5.35-4.2z"/></svg>
        
        <h2 class="text-3xl md:text-5xl lg:text-6xl font-serif font-bold text-white leading-tight mb-8">
            <span class="block text-brand-coral mb-2">Sustainable Elegance.</span>
            Setiap helai benang menyimpan cerita masa lalu yang pantas <span class="italic font-light">dirayakan</span> hari ini.
        </h2>
        
        <p class="text-gray-400 text-lg max-w-2xl mx-auto mb-12">
            Kami menghadirkan platform untuk potongan-potongan archive fashion menakjubkan, menjauhkan gaya eksklusif dari sifat konsumtif. 
        </p>
        
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-white border-b border-brand-coral hover:text-brand-coral transition-colors pb-1 text-lg tracking-wide">
            Jadilah Bagian Perubahan Cerdas
        </a>
    </div>
</div>
@endsection
