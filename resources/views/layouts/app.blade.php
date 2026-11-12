<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Demplane') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="font-sans antialiased bg-brand-light text-gray-800 flex flex-col min-h-screen selection:bg-brand-coral selection:text-white">
    
    <!-- Navbar (Glassmorphism) -->
    <nav x-data="{ open: false, userOpen: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{'bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-100': scrolled, 'bg-transparent': !scrolled}"
         class="fixed w-full top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-3xl font-serif font-bold tracking-widest flex items-center"
                       :class="{'text-brand-navy': scrolled, 'text-gray-900': !scrolled}">
                        <span class="text-brand-coral mr-1">D</span>emplane.
                    </a>
                </div>

                @if(request()->routeIs('partner.*'))
                    <!-- Desktop Navigation (Partner) -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        <a href="{{ route('home') }}" class="text-sm font-semibold tracking-wide uppercase transition-colors hover:text-brand-coral" :class="{'text-gray-600': scrolled, 'text-gray-800': !scrolled}">Kembali ke Toko</a>
                        <a href="#informasi" class="text-sm font-semibold tracking-wide uppercase transition-colors hover:text-brand-coral" :class="{'text-gray-600': scrolled, 'text-gray-800': !scrolled}">Pusat Informasi</a>
                        <a href="{{ route('partner.register') }}" class="text-sm font-bold tracking-wide uppercase transition-colors text-brand-coral hover:text-pink-600">Daftar Sekarang</a>
                    </div>
                @else
                    <!-- Desktop Navigation (Default) -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        <a href="{{ route('home') }}" class="text-sm font-semibold tracking-wide uppercase transition-colors hover:text-brand-coral" :class="{'text-gray-600': scrolled, 'text-gray-800': !scrolled}">Beranda</a>
                        <a href="{{ route('products.index') }}" class="text-sm font-semibold tracking-wide uppercase transition-colors hover:text-brand-coral" :class="{'text-gray-600': scrolled, 'text-gray-800': !scrolled}">Koleksi</a>
                        <a href="{{ route('products.index', ['category' => 'pria']) }}" class="text-sm font-semibold tracking-wide uppercase transition-colors hover:text-brand-coral" :class="{'text-gray-600': scrolled, 'text-gray-800': !scrolled}">Pria</a>
                        <a href="{{ route('products.index', ['category' => 'wanita']) }}" class="text-sm font-semibold tracking-wide uppercase transition-colors hover:text-brand-coral" :class="{'text-gray-600': scrolled, 'text-gray-800': !scrolled}">Wanita</a>
                        <a href="{{ route('partner.index') }}" class="text-sm font-bold tracking-wide uppercase transition-colors text-brand-coral hover:text-pink-600">Jadi Mitra</a>
                    </div>
                @endif

                <!-- Right Side Elements -->
                <div class="hidden sm:flex sm:items-center sm:space-x-6">
                    <!-- Search -->
                    <form action="{{ route('products.index') }}" method="GET" class="relative group">
                        <input type="text" name="search" placeholder="Cari barang..." 
                               class="w-48 xl:w-64 bg-gray-100/50 backdrop-blur border border-transparent rounded-full py-2.5 pl-5 pr-10 text-sm text-gray-800 placeholder-gray-500 focus:bg-white focus:border-gray-200 focus:ring-0 transition-all duration-300">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-brand-coral transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>

                    <!-- Cart Icon -->
                    @auth
                    <a href="{{ route('cart.index') }}" class="relative transition-colors p-2 hover:text-brand-coral" :class="{'text-brand-navy': scrolled, 'text-gray-800': !scrolled}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        @php $cartCount = auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0; @endphp
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-brand-coral rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>
                    @endauth

                    <!-- Auth Links -->
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-semibold tracking-wide transition-colors hover:text-brand-coral" :class="{'text-gray-600': scrolled, 'text-gray-800': !scrolled}">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-brand-navy text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-gray-800 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">Daftar</a>
                    @else
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button @click="userOpen = !userOpen" @click.away="userOpen = false" class="flex items-center space-x-2 focus:outline-none bg-gray-100/50 backdrop-blur px-4 py-2 rounded-full hover:bg-gray-100 transition-colors">
                                <span class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</span>
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="userOpen" style="display: none;"
                                 class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 py-2 z-50">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-brand-coral font-medium">Dashboard Admin</a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                @endif
                                
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-brand-coral font-medium">Pesanan Saya</a>
                                <a href="{{ route('wishlists.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-brand-coral font-medium">Wishlist</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-brand-coral font-medium">Pengaturan Akun</a>
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open" class="text-gray-300 hover:text-white p-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" style="display: none;" class="sm:hidden bg-white/95 backdrop-blur-md border-t border-gray-100 pb-4 shadow-lg absolute w-full left-0 top-full">
            <div class="px-4 py-3">
                <form action="{{ route('products.index') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Cari barang..." class="w-full bg-gray-100 border-none rounded-lg py-3 pl-4 pr-10 text-gray-800 placeholder-gray-500 focus:ring-2 focus:ring-brand-coral">
                </form>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                @if(request()->routeIs('partner.*'))
                    <a href="{{ route('home') }}" class="block px-4 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 hover:text-brand-coral">Kembali ke Toko</a>
                    <a href="#informasi" class="block px-4 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 hover:text-brand-coral">Pusat Informasi</a>
                    <a href="{{ route('partner.register') }}" class="block px-4 py-2 text-base font-bold text-brand-coral hover:bg-gray-50">Daftar Sekarang</a>
                @else
                    <a href="{{ route('home') }}" class="block px-4 py-2 text-base font-semibold text-gray-800 hover:bg-gray-50 hover:text-brand-coral">Beranda</a>
                    <a href="{{ route('products.index') }}" class="block px-4 py-2 text-base font-semibold text-gray-600 hover:bg-gray-50 hover:text-brand-navy">Koleksi</a>
                    <a href="{{ route('partner.index') }}" class="block px-4 py-2 text-base font-bold text-brand-coral hover:bg-gray-50">Jadi Mitra (Curator)</a>
                @endif
                
                @auth
                    <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-base font-semibold text-gray-600 hover:bg-gray-50 hover:text-brand-navy">Keranjang Belanja</a>
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-semibold text-gray-600 hover:bg-gray-50 hover:text-brand-navy">Pesanan Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-semibold text-red-500 hover:bg-gray-50">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-semibold text-gray-600 hover:bg-gray-50 hover:text-brand-navy">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-bold text-brand-coral hover:bg-gray-50">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Session Alerts -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    
    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Page Heading (Breeze Support) -->
    @isset($header)
        <header class="bg-white shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Main Content Area -->
    <main class="flex-grow w-full pt-20">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Footer -->
    <footer class="bg-brand-navy border-t border-white/10 pt-16 pb-8 mt-12 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 lg:gap-16 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <a href="{{ route('home') }}" class="text-3xl font-serif font-bold text-white tracking-widest flex items-center mb-6">
                        <span class="text-brand-coral mr-1">D</span>emplane.
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">Misi kami adalah mengurangi limbah tekstil dengan memberikan kesempatan kedua pada fashion berkualitas tinggi agar pesonanya tetap memancar.</p>
                </div>
                
                <div class="col-span-1"></div>

                <div class="col-span-1">
                    <h4 class="text-lg font-bold text-white mb-6">Informasi</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-gray-400 hover:text-brand-coral transition-colors">Cara Belanja</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-brand-coral transition-colors">Kebijakan Pengiriman</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-brand-coral transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-brand-coral transition-colors">Tanya Jawab (FAQ)</a></li>
                    </ul>
                </div>
                
                <div class="col-span-1">
                    <h4 class="text-lg font-bold text-white mb-6">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 text-brand-coral flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            hello@demplane.id
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 text-brand-coral flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +62 811 2233 4455
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} Demplane. All rights reserved.</p>
                <div class="mt-4 md:mt-0 space-x-4">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                    <a href="#" class="hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                offset: 50
            });
        });
    </script>
</body>
</html>
