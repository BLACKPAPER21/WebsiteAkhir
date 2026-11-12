<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Demplane</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Vite Scripts (Optional for UI) -->
    <!-- We will rely on inline CSS and Tailwind CDN/Custom CSS for this example to fulfill the design system needs efficiently -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#1a1a2e',
                            coral: '#e94560',
                            light: '#f5f5f5',
                            dark: '#0f0f1a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f5f5f5; color: #1a1a2e; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="font-sans antialiased text-brand-navy">
    <div class="flex h-screen bg-brand-light">
        <!-- Sidebar -->
        <aside class="w-64 bg-brand-navy text-white flex flex-col shadow-xl">
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-2xl font-serif font-bold text-brand-coral">Demplane Admin</h1>
            </div>
            
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-brand-coral text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-brand-coral text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                    Produk
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-brand-coral text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                    Pesanan
                </a>
                <a href="{{ route('admin.partners.index') }}" class="flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.partners.*') ? 'bg-brand-coral text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                    <span>Pendaftaran Mitra</span>
                    @php
                        $pendingCount = \App\Models\SellerApplication::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
            </nav>
            
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Admin</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-900 transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
            <!-- Header -->
            <header class="bg-white shadow-sm glass-panel p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                    <a href="{{ route('home') }}" target="_blank" class="text-sm text-brand-coral hover:underline font-medium flex items-center gap-1">
                        Lihat Website &rarr;
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6">
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
