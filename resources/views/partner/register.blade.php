@extends('layouts.app')

@section('content')
<!-- Aesthetic Header -->
<div class="relative py-24 bg-brand-navy overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
    
    <!-- Abstract 3D Blur Balls -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-brand-coral/20 blur-[100px] pointer-events-none animate-pulse"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-light/10 blur-[80px] pointer-events-none"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white z-10" data-aos="fade-up" data-aos-duration="1000">
        <span class="inline-block py-1.5 px-4 rounded-full bg-brand-coral/10 border border-brand-coral/20 text-brand-coral text-xs font-bold tracking-widest uppercase mb-6 backdrop-blur-md">
            Demplane Curator Program
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-7xl font-serif font-bold leading-tight mb-6">
            Buka Lembaran Baru <br/>
            Untuk <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-coral to-pink-500 italic">Koleksi Anda.</span>
        </h1>
        <p class="text-base md:text-lg text-gray-400 mb-0 leading-relaxed max-w-2xl mx-auto font-light">
            Bergabunglah sebagai Mitra Penjual. Kurasi arsip fashion premium Anda, temukan audiens baru, dan berkontribusi pada siklus fashion berkelanjutan bersama Demplane.
        </p>
    </div>
</div>

<!-- Main Form Section -->
<div class="py-20 bg-brand-light relative z-20 -mt-10 rounded-t-[3rem]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mx-auto">
            <!-- Form Panel -->
            <div data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-2xl shadow-brand-navy/10 border border-gray-100">
                    <div class="mb-8 border-b border-gray-100 pb-6">
                        <h2 class="text-3xl font-serif font-bold text-brand-navy mb-2">Formulir Kemitraan</h2>
                        <p class="text-gray-500">Lengkapi data di bawah ini. Kami menjamin privasi dokumen identitas Anda.</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                            <div class="flex">
                                <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <div>
                                    <h4 class="text-sm font-medium text-red-800">Terdapat kesalahan pada isian Anda:</h4>
                                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('partner.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="partner-form">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Toko -->
                            <div>
                                <label for="shop_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Toko / Brand Anda <span class="text-brand-coral">*</span></label>
                                <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-navy focus:ring-brand-navy bg-gray-50 focus:bg-white transition-colors"
                                    placeholder="Contoh: Vintage Vibes ID">
                            </div>

                            <!-- Nomor WhatsApp -->
                            <div>
                                <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp <span class="text-brand-coral">*</span></label>
                                <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-navy focus:ring-brand-navy bg-gray-50 focus:bg-white transition-colors"
                                    placeholder="Contoh: 08123456789">
                            </div>
                        </div>

                        <!-- ===== UPLOAD & SCAN KTP ===== -->
                        <div x-data="ktpScanner()" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Foto KTP Asli <span class="text-brand-coral">*</span></label>
                                <p class="text-xs text-gray-500 mb-3">Foto KTP akan otomatis dibaca dan diverifikasi. Dokumen ini hanya untuk verifikasi internal Admin. Maks 4MB (JPG/PNG).</p>
                            </div>

                            <!-- Drop Zone -->
                            <div 
                                class="relative flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-xl transition-all duration-300 cursor-pointer"
                                :class="isDragging ? 'border-brand-coral bg-brand-coral/5' : 'border-gray-300 hover:border-brand-navy bg-gray-50'"
                                id="drop-zone"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                @click="$refs.ktpInput.click()"
                            >
                                <!-- Preview gambar -->
                                <template x-if="previewUrl">
                                    <div class="w-full text-center">
                                        <img :src="previewUrl" class="max-h-48 mx-auto rounded-lg object-contain mb-3 shadow" alt="Preview KTP">
                                        <p class="text-xs text-brand-navy font-semibold" x-text="fileName"></p>
                                        <p class="text-xs text-gray-400 mt-1">Klik untuk ganti foto</p>
                                    </div>
                                </template>
                                <template x-if="!previewUrl">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium text-brand-navy">Klik untuk unggah</span> atau tarik dan lepas
                                        </p>
                                        <p class="text-xs text-gray-500">JPG, PNG, WEBP hingga 4MB</p>
                                    </div>
                                </template>
                                <input 
                                    x-ref="ktpInput"
                                    id="ktp_image" 
                                    name="ktp_image" 
                                    type="file" 
                                    class="sr-only" 
                                    required 
                                    accept="image/jpeg,image/png,image/jpg,image/webp"
                                    @change="handleFileSelect($event)"
                                >
                            </div>

                            <!-- Panel Scan OCR -->
                            <div 
                                x-show="previewUrl || scanning || scanDone"
                                x-transition
                                class="rounded-2xl border overflow-hidden"
                                :class="scanDone && !scanError ? 'border-green-200 bg-green-50' : (scanError ? 'border-red-200 bg-red-50' : 'border-blue-200 bg-blue-50')"
                            >
                                <!-- Loading state -->
                                <div x-show="scanning" class="p-5 flex items-center gap-4">
                                    <div class="relative flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full border-4 border-brand-navy/20 border-t-brand-navy animate-spin"></div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-brand-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-brand-navy text-sm">Memindai dokumen KTP…</p>
                                        <p class="text-xs text-blue-600 mt-0.5" x-text="scanProgress"></p>
                                    </div>
                                </div>

                                <!-- Error state -->
                                <div x-show="scanError && !scanning" class="p-5">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <div>
                                            <p class="font-semibold text-red-700 text-sm">Gagal membaca KTP otomatis</p>
                                            <p class="text-xs text-red-600 mt-1">Pastikan foto KTP jelas dan tidak buram. Anda tetap bisa melanjutkan pendaftaran — admin akan memverifikasi secara manual.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Success state -->
                                <div x-show="scanDone && !scanError && !scanning">
                                    <div class="px-5 pt-4 pb-3 flex items-center gap-2 border-b border-green-200">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="font-bold text-green-800 text-sm">Data KTP berhasil terbaca!</p>
                                        <p class="text-xs text-green-600 ml-auto">Periksa & koreksi jika ada yang salah</p>
                                    </div>
                                    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <!-- NIK -->
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">NIK</label>
                                            <input 
                                                type="text" 
                                                name="ktp_nik" 
                                                x-model="ktpData.nik"
                                                class="w-full px-3 py-2 rounded-lg border border-green-200 bg-white text-sm font-mono focus:border-brand-navy focus:ring-brand-navy"
                                                placeholder="16 digit NIK"
                                                maxlength="20"
                                            >
                                        </div>
                                        <!-- Nama -->
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Sesuai KTP</label>
                                            <input 
                                                type="text" 
                                                name="ktp_name"
                                                x-model="ktpData.name"
                                                class="w-full px-3 py-2 rounded-lg border border-green-200 bg-white text-sm focus:border-brand-navy focus:ring-brand-navy"
                                                placeholder="Nama lengkap"
                                            >
                                        </div>
                                        <!-- Tanggal Lahir -->
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tanggal Lahir</label>
                                            <input 
                                                type="text" 
                                                name="ktp_dob"
                                                x-model="ktpData.dob"
                                                class="w-full px-3 py-2 rounded-lg border border-green-200 bg-white text-sm focus:border-brand-navy focus:ring-brand-navy"
                                                placeholder="DD-MM-YYYY"
                                            >
                                        </div>
                                        <!-- Alamat -->
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alamat</label>
                                            <input 
                                                type="text" 
                                                name="ktp_address"
                                                x-model="ktpData.address"
                                                class="w-full px-3 py-2 rounded-lg border border-green-200 bg-white text-sm focus:border-brand-navy focus:ring-brand-navy"
                                                placeholder="Alamat lengkap sesuai KTP"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <!-- Belum scan -->
                                <div x-show="previewUrl && !scanning && !scanDone && !scanError" class="p-4 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                                    </div>
                                    <p class="text-sm text-blue-700">Foto terpilih — scan otomatis akan dimulai…</p>
                                </div>
                            </div>

                            <!-- Hidden fields untuk data KTP saat gagal scan -->
                            <template x-if="scanError">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-5 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                    <p class="sm:col-span-2 text-xs font-bold text-gray-500 uppercase tracking-wider">Isi data KTP secara manual (opsional):</p>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">NIK</label>
                                        <input type="text" name="ktp_nik" x-model="ktpData.nik" class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm" placeholder="16 digit NIK">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Nama Sesuai KTP</label>
                                        <input type="text" name="ktp_name" x-model="ktpData.name" class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm" placeholder="Nama lengkap">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Tanggal Lahir</label>
                                        <input type="text" name="ktp_dob" x-model="ktpData.dob" class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm" placeholder="DD-MM-YYYY">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Alamat</label>
                                        <input type="text" name="ktp_address" x-model="ktpData.address" class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm" placeholder="Alamat lengkap">
                                    </div>
                                </div>
                            </template>
                        </div>
                        <!-- ===== END SCAN KTP ===== -->

                        <!-- Persetujuan -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 text-brand-navy bg-gray-100 border-gray-300 rounded focus:ring-brand-navy focus:ring-2">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-900">Syarat & Ketentuan</label>
                                <p class="text-gray-500 text-xs">Saya menyatakan bahwa data KTP yang diberikan adalah asli milik saya, dan saya setuju mematuhi seluruh panduan kurasi produk di platform Demplane.</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button 
                                type="submit" 
                                :disabled="scanning"
                                :class="scanning ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-800 hover:-translate-y-1'"
                                class="w-full flex justify-center items-center gap-2 py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-brand-navy/20 text-sm font-bold uppercase tracking-widest text-white bg-brand-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-navy transition-all duration-300 transform"
                            >
                                <svg x-show="scanning" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                <span x-text="scanning ? 'Memindai KTP…' : 'Kirim Aplikasi Mitra'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tesseract.js CDN (OCR engine - client side, free, no API) -->
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>

<script>
function ktpScanner() {
    return {
        previewUrl: null,
        fileName: '',
        isDragging: false,
        scanning: false,
        scanDone: false,
        scanError: false,
        scanProgress: 'Mempersiapkan mesin baca...',
        ktpData: { nik: '', name: '', dob: '', address: '' },

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) this.processFile(file);
        },

        handleDrop(event) {
            this.isDragging = false;
            const file = event.dataTransfer.files[0];
            if (file) {
                // Assign ke input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                this.$refs.ktpInput.files = dataTransfer.files;
                this.processFile(file);
            }
        },

        processFile(file) {
            this.previewUrl = URL.createObjectURL(file);
            this.fileName = file.name;
            this.scanDone = false;
            this.scanError = false;
            this.ktpData = { nik: '', name: '', dob: '', address: '' };
            
            // Delay kecil agar preview muncul dulu
            setTimeout(() => this.runOCR(file), 300);
        },

        async runOCR(file) {
            this.scanning = true;
            this.scanProgress = 'Memuat mesin OCR...';

            try {
                const worker = await Tesseract.createWorker('ind', 1, {
                    logger: (m) => {
                        if (m.status === 'recognizing text') {
                            const pct = Math.round((m.progress || 0) * 100);
                            this.scanProgress = `Membaca teks KTP... ${pct}%`;
                        } else if (m.status === 'loading language traineddata') {
                            this.scanProgress = 'Memuat bahasa Indonesia...';
                        } else if (m.status === 'initializing api') {
                            this.scanProgress = 'Menginisialisasi mesin baca...';
                        }
                    }
                });

                this.scanProgress = 'Menganalisis gambar KTP...';
                const result = await worker.recognize(file);
                await worker.terminate();

                const text = result.data.text;
                console.log('[KTP RAW OCR]', text); // debug

                this.parseKTP(text);
                this.scanDone = true;
                this.scanError = false;
            } catch(err) {
                console.error('[OCR ERROR]', err);
                this.scanError = true;
                this.scanDone = false;
            } finally {
                this.scanning = false;
            }
        },

        parseKTP(text) {
            const lines = text.split('\n').map(l => l.trim()).filter(Boolean);

            // --- NIK ---
            // Cari baris yang memiliki 16 digit angka berurutan
            const nikMatch = text.match(/\b(\d{16})\b/);
            if (nikMatch) this.ktpData.nik = nikMatch[1];

            // --- NAMA ---
            for (const line of lines) {
                const upper = line.toUpperCase();
                if (upper.includes('NAMA') && !upper.includes('NAMA DEPAN')) {
                    const parts = line.split(':');
                    if (parts.length > 1) {
                        this.ktpData.name = parts.slice(1).join(':').trim().replace(/[^A-Za-z\s]/g, '').trim();
                        if (this.ktpData.name.length > 2) break;
                    }
                }
            }

            // --- TANGGAL LAHIR ---
            const dobMatch = text.match(/(\d{2}[-\/]\d{2}[-\/]\d{4})/);
            if (dobMatch) this.ktpData.dob = dobMatch[1];

            // --- ALAMAT ---
            let addressLines = [];
            let capturing = false;
            for (const line of lines) {
                const upper = line.toUpperCase();
                if (upper.includes('ALAMAT') || upper.includes('JALAN') || upper.includes('JL')) {
                    capturing = true;
                    const parts = line.split(':');
                    const val = parts.length > 1 ? parts.slice(1).join(':').trim() : line.replace(/ALAMAT\s*:?/i, '').trim();
                    if (val) addressLines.push(val);
                } else if (capturing) {
                    if (upper.includes('RT') || upper.includes('RW') || upper.includes('KEL') || upper.includes('KEC') || upper.includes('KOTA') || upper.includes('KAB')) {
                        addressLines.push(line);
                        if (addressLines.length >= 3) break;
                    } else {
                        break;
                    }
                }
            }
            if (addressLines.length > 0) {
                this.ktpData.address = addressLines.join(', ');
            }
        }
    }
}
</script>
@endsection
