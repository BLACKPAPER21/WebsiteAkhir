<x-mail::message>
# Aplikasi Demplane Partner Baru

Ada pengguna yang baru saja mendaftar untuk menjadi Mitra Kurator (Seller) di Demplane.

**Detail Pendaftar:**
- **Nama Pendaftar:** {{ $application->user->name }}
- **Email:** {{ $application->user->email }}
- **Nama Toko / Brand:** {{ $application->shop_name }}

Silakan periksa dasbor Admin untuk memverifikasi dokumen foto KTP pelamar dan memberikan persetujuan atau penolakan.

<x-mail::button :url="route('admin.partners.index')">
Tinjau Aplikasi di Dasbor Admin
</x-mail::button>

Terima kasih,<br>
Sistem Notifikasi {{ config('app.name') }}
</x-mail::message>
