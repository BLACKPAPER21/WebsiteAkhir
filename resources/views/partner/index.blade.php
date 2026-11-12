@extends('layouts.app')

@section('content')
<!-- Landing Page Kemitraan -->
<div class="relative min-h-screen bg-brand-light flex flex-col pt-10">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, #1a202c 1px, transparent 0); background-size: 40px 40px;"></div>
    
    <div class="relative flex-grow flex items-center justify-center max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
        <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden w-full" data-aos="zoom-in" data-aos-duration="1000">
            <div class="grid lg:grid-cols-2">
                <!-- Left Banner Image -->
                <div class="bg-brand-navy relative hidden lg:block overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-50 filter grayscale" alt="Fashion Curator">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-navy via-brand-navy/60 to-transparent"></div>
                    <div class="absolute bottom-12 left-12 right-12 z-10 text-white">
                        <span class="inline-block py-1.5 px-4 rounded-full bg-brand-coral/20 border border-brand-coral/30 text-brand-coral text-xs font-bold tracking-[0.2em] uppercase mb-4 backdrop-blur-md">
                            Demplane Curator
                        </span>
                        <h2 class="text-4xl font-serif font-bold mb-4 leading-tight">Kurasi Fashion.<br/>Kurasi Masa Depan.</h2>
                        <p class="text-gray-300 font-light leading-relaxed">Bergabunglah dalam pergerakan fashion sirkular. Bersama-sama, kita memperpanjang usia pakaian premium dan mengurangi limbah tekstil.</p>
                    </div>
                </div>

                <!-- Right Information Text -->
                <div class="p-8 sm:p-12 md:p-16 flex flex-col justify-center">
                    <h1 class="text-3xl sm:text-4xl font-serif font-bold text-brand-navy mb-6">Program Kemitraan Demplane</h1>
                    
                    <p class="text-gray-500 mb-8 font-light leading-relaxed">
                        Kami mengundang Anda yang memiliki koleksi pakaian premium namun jarang dipakai, untuk menjadi Mitra Penjual (Curator) di platform kami. 
                    </p>

                    <div class="space-y-6 mb-10">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-8 h-8 rounded-full bg-brand-coral/10 text-brand-coral flex items-center justify-center">
                                    <span class="font-bold text-sm">1</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-bold text-gray-900">Validasi Identitas Asli</h4>
                                <p class="text-gray-500 text-sm mt-1">Demi keamanan komunitas, Anda wajib mengunggah Foto KTP asli. Data Anda dienkripsi dan 100% rahasia.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-8 h-8 rounded-full bg-brand-coral/10 text-brand-coral flex items-center justify-center">
                                    <span class="font-bold text-sm">2</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-bold text-gray-900">Komitmen Kurasi</h4>
                                <p class="text-gray-500 text-sm mt-1">Barang yang dijual harus 100% asli (Original) dan dalam kondisi layak pakai (Preloved Premium).</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-8 h-8 rounded-full bg-brand-coral/10 text-brand-coral flex items-center justify-center">
                                    <span class="font-bold text-sm">3</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-bold text-gray-900">Persetujuan Admin</h4>
                                <p class="text-gray-500 text-sm mt-1">Setiap aplikasi yang masuk akan ditinjau oleh Admin Demplane dalam 1-2 hari kerja sebelum akun Anda aktif.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 text-center sm:text-left">
                        <p class="text-sm text-gray-400 mb-6 font-light">Dengan melanjutkan, Anda menyatakan paham dan setuju dengan syarat & ketentuan komunitas kami.</p>
                        <a href="{{ route('partner.register') }}" class="inline-flex justify-center items-center px-8 py-4 bg-brand-navy text-white text-sm font-bold uppercase tracking-widest rounded-full hover:bg-brand-coral hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 w-full sm:w-auto">
                            Mulai Pendaftaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Information Slider Section (Slide to Slide) -->
<div id="informasi" class="w-full bg-white py-24 relative overflow-hidden" x-data="{ activeSlide: 1, maxSlide: 5 }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-brand-coral text-sm font-bold tracking-[0.2em] uppercase mb-4 block">Pusat Informasi</span>
            <h2 class="text-3xl md:text-5xl font-serif font-bold text-brand-navy mb-4">Panduan Mitra Demplane</h2>
            <div class="w-24 h-1 bg-brand-coral mx-auto"></div>
        </div>

        <!-- Slider Navigation Tabs -->
        <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-12" data-aos="fade-up" data-aos-delay="100">
            <button @click="activeSlide = 1" :class="activeSlide === 1 ? 'bg-brand-navy text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-6 py-3 rounded-full text-xs md:text-sm font-bold uppercase tracking-wide transition-all duration-300">Cara Kerja</button>
            <button @click="activeSlide = 2" :class="activeSlide === 2 ? 'bg-brand-navy text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-6 py-3 rounded-full text-xs md:text-sm font-bold uppercase tracking-wide transition-all duration-300">Kebijakan Pengiriman</button>
            <button @click="activeSlide = 3" :class="activeSlide === 3 ? 'bg-brand-navy text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-6 py-3 rounded-full text-xs md:text-sm font-bold uppercase tracking-wide transition-all duration-300">Syarat & Ketentuan</button>
            <button @click="activeSlide = 4" :class="activeSlide === 4 ? 'bg-brand-navy text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-6 py-3 rounded-full text-xs md:text-sm font-bold uppercase tracking-wide transition-all duration-300">Tanya Jawab (FAQ)</button>
            <button @click="activeSlide = 5" :class="activeSlide === 5 ? 'bg-brand-navy text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-6 py-3 rounded-full text-xs md:text-sm font-bold uppercase tracking-wide transition-all duration-300">Formulir Kemitraan</button>
        </div>

        <!-- Slider Content Area -->
        <div class="relative bg-gray-50 rounded-[2rem] p-6 md:p-16 border border-gray-100 shadow-inner overflow-hidden min-h-[420px]" data-aos="fade-up" data-aos-delay="200">
            
            <!-- Slide 1: Cara Kerja -->
            <div x-show="activeSlide === 1" x-transition:enter="transition ease-out duration-500 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" class="max-w-4xl mx-auto" style="display: none;">
                <h3 class="text-2xl font-serif font-bold text-brand-navy mb-8 text-center md:text-left">Cara Kerja Kemitraan</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-brand-coral/10 text-brand-coral rounded-full flex items-center justify-center font-bold text-xl mb-4">1</div>
                        <h4 class="font-bold text-gray-900 mb-2">Daftar & Kurasi</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">Daftar menggunakan KTP. Setelah disetujui, Anda dapat mulai mengunggah foto barang fesyen preloved premium Anda ke Dasbor.</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-brand-coral/10 text-brand-coral rounded-full flex items-center justify-center font-bold text-xl mb-4">2</div>
                        <h4 class="font-bold text-gray-900 mb-2">Persetujuan Kualitas</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">Tim ahli kami akan memeriksa foto dan deskripsi barang untuk memastikan orisinalitas dan standar kualitas Demplane.</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-brand-coral/10 text-brand-coral rounded-full flex items-center justify-center font-bold text-xl mb-4">3</div>
                        <h4 class="font-bold text-gray-900 mb-2">Terjual & Cair</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">Barang tampil di katalog. Saat terjual, kirim barang ke pembeli. Dana akan otomatis cair ke rekening Anda secara berkala.</p>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Kebijakan Pengiriman -->
            <div x-show="activeSlide === 2" x-transition:enter="transition ease-out duration-500 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" class="max-w-4xl mx-auto" style="display: none;">
                <h3 class="text-2xl font-serif font-bold text-brand-navy mb-8 text-center md:text-left">Kebijakan Pengiriman Demplane</h3>
                <div class="space-y-6 text-gray-600">
                    <div class="flex items-start bg-white p-6 rounded-2xl shadow-sm border border-gray-50">
                        <svg class="w-8 h-8 text-brand-coral flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 text-lg">Tanggung Jawab Mitra</h4>
                            <p class="text-sm mt-2 leading-relaxed">Mitra penjual bertanggung jawab untuk mengemas barang dengan rapi, aman, dan mengirimkannya menggunakan layanan logistik dalam waktu maksimal 2x24 jam sejak pesanan dibayar.</p>
                        </div>
                    </div>
                    <div class="flex items-start bg-white p-6 rounded-2xl shadow-sm border border-gray-50">
                        <svg class="w-8 h-8 text-brand-coral flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 text-lg">Resi Otomatis (Cashless)</h4>
                            <p class="text-sm mt-2 leading-relaxed">Sistem Demplane akan mencetak resi otomatis di Dasbor Mitra. Anda cukup menempelkannya di paket tanpa perlu membayar ongkos kirim lagi ke kurir.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Syarat & Ketentuan -->
            <div x-show="activeSlide === 3" x-transition:enter="transition ease-out duration-500 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" class="max-w-4xl mx-auto" style="display: none;">
                <h3 class="text-2xl font-serif font-bold text-brand-navy mb-8 text-center md:text-left">Syarat & Ketentuan Kurator</h3>
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100">
                    <ul class="space-y-4 text-gray-600 text-sm leading-relaxed">
                        <li class="flex items-start">
                            <span class="w-2 h-2 rounded-full bg-brand-coral mt-2 mr-3 flex-shrink-0"></span>
                            <div><strong class="text-gray-900">Keaslian Barang:</strong> Demplane memberlakukan kebijakan <span class="italic text-brand-coral">Zero Tolerance</span> terhadap barang palsu (KW/Mirror). Terbukti menjual barang palsu akan mengakibatkan pemblokiran akun dan dana ditahan.</div>
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 rounded-full bg-brand-coral mt-2 mr-3 flex-shrink-0"></span>
                            <div><strong class="text-gray-900">Kondisi Barang:</strong> Barang harus dalam kondisi minimal 8/10 (sangat baik). Tidak ada robek, noda permanen, atau bau tidak sedap. Barang harus dicuci sebelum dikirim.</div>
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 rounded-full bg-brand-coral mt-2 mr-3 flex-shrink-0"></span>
                            <div><strong class="text-gray-900">Validasi Identitas:</strong> Akun mitra hanya akan diaktifkan jika Foto KTP yang diunggah valid dan terbaca jelas oleh Admin.</div>
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 rounded-full bg-brand-coral mt-2 mr-3 flex-shrink-0"></span>
                            <div><strong class="text-gray-900">Biaya Platform:</strong> Demplane membebankan biaya kurasi dan operasional platform sebesar 5% dari total harga akhir barang terjual.</div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Slide 4: FAQ -->
            <div x-show="activeSlide === 4" x-transition:enter="transition ease-out duration-500 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" class="max-w-4xl mx-auto" style="display: none;">
                <h3 class="text-2xl font-serif font-bold text-brand-navy mb-8 text-center md:text-left">Tanya Jawab (FAQ)</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-xl border border-gray-100 hover:border-brand-coral/30 transition-colors">
                        <h4 class="font-bold text-gray-900 text-sm mb-2">Berapa lama proses persetujuan akun Mitra?</h4>
                        <p class="text-gray-500 text-sm">Tim kami akan memproses aplikasi kemitraan Anda beserta pengecekan identitas dalam waktu maksimal 1-2 hari kerja.</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-gray-100 hover:border-brand-coral/30 transition-colors">
                        <h4 class="font-bold text-gray-900 text-sm mb-2">Kapan uang hasil penjualan saya cair?</h4>
                        <p class="text-gray-500 text-sm">Dana penjualan akan masuk ke saldo Dasbor Anda 24 jam setelah barang dikonfirmasi diterima oleh pembeli tanpa keluhan.</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-gray-100 hover:border-brand-coral/30 transition-colors">
                        <h4 class="font-bold text-gray-900 text-sm mb-2">Apakah saya bisa membatalkan pesanan?</h4>
                        <p class="text-gray-500 text-sm">Pembatalan dapat dilakukan sebelum pesanan dibayar. Membatalkan pesanan yang sudah lunas akan menurunkan rating Mitra Anda secara signifikan.</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-gray-100 hover:border-brand-coral/30 transition-colors">
                        <h4 class="font-bold text-gray-900 text-sm mb-2">Siapa yang menanggung ongkir pengembalian?</h4>
                        <p class="text-gray-500 text-sm">Jika pengembalian terjadi karena barang tidak sesuai deskripsi (cacat), ongkir ditanggung oleh Anda (Mitra).</p>
                    </div>
                </div>
            </div>

            <!-- Slide 5: Formulir Kemitraan -->
            <div x-show="activeSlide === 5" x-transition:enter="transition ease-out duration-500 transform" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0" class="max-w-4xl mx-auto" style="display: none;">
                <h3 class="text-2xl font-serif font-bold text-brand-navy mb-8 text-center md:text-left">Persiapan Formulir Kemitraan</h3>
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100">
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Sebelum mengeklik tombol <strong>Daftar Sekarang</strong>, pastikan Anda telah menyiapkan beberapa informasi dan dokumen berikut untuk memperlancar proses pendaftaran:
                    </p>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-brand-coral/10 text-brand-coral rounded-xl flex items-center justify-center font-bold flex-shrink-0 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">1. Nama Toko / Brand</h4>
                                <p class="text-sm text-gray-500 mt-1">Siapkan nama toko unik Anda. Nama ini akan muncul di profil penjualan Anda dan akan dilihat oleh semua calon pembeli.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-brand-coral/10 text-brand-coral rounded-xl flex items-center justify-center font-bold flex-shrink-0 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">2. Nomor WhatsApp Aktif</h4>
                                <p class="text-sm text-gray-500 mt-1">Kami memerlukan nomor WhatsApp yang valid untuk mengirimkan notifikasi penjualan penting, update persetujuan, maupun untuk keperluan penjemputan barang (pickup).</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-brand-coral/10 text-brand-coral rounded-xl flex items-center justify-center font-bold flex-shrink-0 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">3. Foto KTP Asli</h4>
                                <p class="text-sm text-gray-500 mt-1">Siapkan file gambar KTP (JPEGs, PNGs, format WebP di bawah 4MB). Pastikan teks KTP terbaca sangat jelas untuk mempercepat proses persetujuan oleh tim Demplane.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next/Prev Control Buttons -->
            <div class="absolute bottom-6 right-6 flex space-x-3">
                <button @click="activeSlide = activeSlide > 1 ? activeSlide - 1 : maxSlide" class="w-12 h-12 rounded-full bg-white shadow-md flex items-center justify-center text-brand-navy hover:bg-brand-coral hover:text-white transition-all transform hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="activeSlide = activeSlide < maxSlide ? activeSlide + 1 : 1" class="w-12 h-12 rounded-full bg-white shadow-md flex items-center justify-center text-brand-navy hover:bg-brand-coral hover:text-white transition-all transform hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
        
        <div class="mt-16 text-center">
            <a href="{{ route('partner.register') }}" class="inline-flex justify-center items-center px-10 py-5 bg-brand-navy text-white text-base font-bold uppercase tracking-widest rounded-full hover:bg-brand-coral hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                Saya Mengerti, Daftar Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
