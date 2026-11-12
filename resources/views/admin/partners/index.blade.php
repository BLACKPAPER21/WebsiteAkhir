@extends('layouts.admin')

@section('header', 'Manajemen Pendaftaran Mitra')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Daftar Aplikasi Mitra (Curator)</h3>
            <p class="text-sm text-gray-500">Kelola persetujuan pengguna yang ingin menjadi penjual di Demplane.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">Pengguna & WA</th>
                    <th class="px-6 py-4 font-medium">Toko / Brand</th>
                    <th class="px-6 py-4 font-medium">Tanggal Daftar</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($applications as $app)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-brand-navy text-white flex items-center justify-center font-bold text-xs mr-3">
                                    {{ substr($app->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $app->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $app->user->email }}</p>
                                    <p class="text-xs text-brand-coral font-medium mt-0.5">WA: {{ $app->whatsapp_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-brand-navy">{{ $app->shop_name }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $app->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                {{ $app->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $app->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $app->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                                {{ ucfirst($app->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <!-- Tombol Lihat Detail (Modal) -->
                            <button onclick="openModal('modal-{{ $app->id }}')" class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-md text-xs font-medium transition-colors">
                                Lihat KTP & Proses
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Modal untuk tiap aplikasi -->
                    <div id="modal-{{ $app->id }}" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
                        <div class="bg-white rounded-2xl w-full max-w-3xl overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 text-left">
                                <h3 class="text-lg font-bold text-gray-900">Verifikasi Mitra: {{ $app->shop_name }}</h3>
                                <button onclick="closeModal('modal-{{ $app->id }}')" class="text-gray-400 hover:text-gray-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            
                            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                                <!-- KTP Preview -->
                                <div>
                                    <h4 class="text-sm font-bold text-gray-700 mb-2">Dokumen KTP</h4>
                                    <div class="bg-gray-100 rounded-xl overflow-hidden border border-gray-200">
                                        @php
                                            $path = Storage::disk('local')->path($app->ktp_image_path);
                                            $base64 = '';
                                            if(file_exists($path)) {
                                                $type = pathinfo($path, PATHINFO_EXTENSION);
                                                $data = file_get_contents($path);
                                                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                            }
                                        @endphp
                                        
                                        @if($base64)
                                            <img src="{{ $base64 }}" alt="KTP" class="w-full h-auto">
                                        @else
                                            <div class="p-10 text-center text-gray-500 text-sm">Gambar KTP tidak ditemukan.</div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Info & Action -->
                                <div class="flex flex-col">
                                    <div class="mb-6">
                                        <h4 class="text-sm font-bold text-gray-700 mb-2">Informasi Pendaftar</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><span class="text-gray-500">Nama:</span> <span class="font-medium">{{ $app->user->name }}</span></li>
                                            <li><span class="text-gray-500">Email:</span> <span class="font-medium">{{ $app->user->email }}</span></li>
                                            <li><span class="text-gray-500">WhatsApp:</span> <span class="font-medium">{{ $app->whatsapp_number }}</span></li>
                                            <li><span class="text-gray-500">Telepon Akun:</span> <span class="font-medium">{{ $app->user->phone ?? '-' }}</span></li>
                                            <li><span class="text-gray-500">Alamat:</span> <span class="font-medium">{{ $app->user->address ?? '-' }}</span></li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Data Hasil Scan KTP -->
                                    @if($app->ktp_nik || $app->ktp_name || $app->ktp_dob || $app->ktp_address)
                                    <div class="mb-5 p-4 rounded-xl bg-green-50 border border-green-200">
                                        <div class="flex items-center gap-2 mb-3">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <h4 class="text-xs font-bold text-green-800 uppercase tracking-wider">Data Scan KTP Otomatis</h4>
                                        </div>
                                        <ul class="space-y-1.5 text-xs">
                                            @if($app->ktp_nik)
                                            <li class="flex gap-2"><span class="text-green-600 font-medium w-20 flex-shrink-0">NIK</span><span class="font-mono text-gray-800 font-bold tracking-wider">{{ $app->ktp_nik }}</span></li>
                                            @endif
                                            @if($app->ktp_name)
                                            <li class="flex gap-2"><span class="text-green-600 font-medium w-20 flex-shrink-0">Nama</span><span class="text-gray-800">{{ $app->ktp_name }}</span></li>
                                            @endif
                                            @if($app->ktp_dob)
                                            <li class="flex gap-2"><span class="text-green-600 font-medium w-20 flex-shrink-0">Tgl. Lahir</span><span class="text-gray-800">{{ $app->ktp_dob }}</span></li>
                                            @endif
                                            @if($app->ktp_address)
                                            <li class="flex gap-2"><span class="text-green-600 font-medium w-20 flex-shrink-0">Alamat</span><span class="text-gray-800">{{ $app->ktp_address }}</span></li>
                                            @endif
                                        </ul>
                                    </div>
                                    @else
                                    <div class="mb-5 p-3 rounded-xl bg-yellow-50 border border-yellow-200">
                                        <p class="text-xs text-yellow-700 flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            Data KTP tidak terbaca otomatis — verifikasi manual via gambar.
                                        </p>
                                    </div>
                                    @endif
                                    
                                    @if($app->status === 'pending')
                                        <div class="mt-auto space-y-3">
                                            <!-- Tombol Approve -->
                                            <form action="{{ route('admin.partners.approve', $app->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-full py-2.5 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors">
                                                    Setujui (Approve)
                                                </button>
                                            </form>
                                            
                                            <!-- Form Reject -->
                                            <form action="{{ route('admin.partners.reject', $app->id) }}" method="POST" class="border-t border-gray-100 pt-3">
                                                @csrf
                                                @method('PATCH')
                                                <input type="text" name="notes" placeholder="Alasan penolakan..." required class="w-full text-sm border-gray-300 rounded-lg mb-2 focus:ring-red-500 focus:border-red-500 px-3 py-2">
                                                <button type="submit" class="w-full py-2.5 px-4 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-lg text-sm transition-colors">
                                                    Tolak (Reject)
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="mt-auto bg-gray-50 p-4 rounded-lg border border-gray-200 text-center">
                                            <p class="text-sm text-gray-600 font-medium">Aplikasi ini telah <strong class="{{ $app->status === 'approved' ? 'text-green-600' : 'text-red-600' }}">{{ strtoupper($app->status) }}</strong>.</p>
                                            @if($app->notes)
                                                <p class="text-xs text-gray-500 mt-2">Catatan: {{ $app->notes }}</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Belum ada pengajuan kemitraan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100">
        {{ $applications->links() }}
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.children[0].classList.remove('scale-95');
            modal.children[0].classList.add('scale-100');
        }, 10);
    }
    
    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.children[0].classList.remove('scale-100');
        modal.children[0].classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
