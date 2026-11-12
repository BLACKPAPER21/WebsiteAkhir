<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerApplication;
use App\Mail\NewPartnerApplicationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        return view('partner.index');
    }

    public function create()
    {
        // Jika sudah partner/seller, redirect ke dashboard
        if (auth()->user()->isSeller()) {
            return redirect()->route('dashboard')->with('success', 'Anda sudah terdaftar sebagai Mitra Demplane.');
        }

        // Cek apakah punya aplikasi yang pending
        $existingApp = SellerApplication::where('user_id', auth()->id())->first();
        if ($existingApp && $existingApp->status === 'pending') {
            return redirect()->route('dashboard')->with('info', 'Aplikasi kemitraan Anda sedang kami tinjau.');
        }

        return view('partner.register');
    }

    public function store(Request $request)
    {
        if (auth()->user()->isSeller()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'shop_name'        => 'required|string|max:255',
            'whatsapp_number'  => 'required|string|max:20',
            'ktp_image'        => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            // Data hasil scan OCR KTP (dikirim dari frontend, opsional)
            'ktp_nik'     => 'nullable|string|max:20',
            'ktp_name'    => 'nullable|string|max:255',
            'ktp_dob'     => 'nullable|string|max:100',
            'ktp_address' => 'nullable|string|max:500',
        ]);

        $path = $request->file('ktp_image')->store('ktp_documents', 'local');

        $application = SellerApplication::create([
            'user_id'          => auth()->id(),
            'shop_name'        => $request->shop_name,
            'whatsapp_number'  => $request->whatsapp_number,
            'ktp_image_path'   => $path,
            'ktp_nik'          => $request->ktp_nik,
            'ktp_name'         => $request->ktp_name,
            'ktp_dob'          => $request->ktp_dob,
            'ktp_address'      => $request->ktp_address,
            'status'           => 'pending',
        ]);

        // Kirim email notifikasi ke admin
        try {
            Mail::to('admin@demplane.com')->send(new NewPartnerApplicationMail($application));
        } catch (\Exception $e) {
            // Abaikan gagal email saat environment local
        }

        return redirect()->route('dashboard')->with('success', 'Terima kasih! Aplikasi Anda telah berhasil dikirim. Kami akan meninjaunya dalam 1-2 hari kerja.');
    }
}
