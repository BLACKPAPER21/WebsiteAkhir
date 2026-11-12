<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerApplication;

class PartnerController extends Controller
{
    public function index()
    {
        $applications = SellerApplication::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.partners.index', compact('applications'));
    }

    public function approve(Request $request, SellerApplication $application)
    {
        $application->update(['status' => 'approved']);
        
        // Jadikan seller + simpan nama toko ke profil user
        $application->user->update([
            'role'      => 'seller',
            'shop_name' => $application->shop_name,
        ]);
        
        return back()->with('success', 'Aplikasi Mitra berhasil disetujui. Pengguna kini memiliki akses Seller.');
    }

    public function reject(Request $request, SellerApplication $application)
    {
        $request->validate(['notes' => 'required|string']);
        
        $application->update([
            'status' => 'rejected',
            'notes' => $request->notes
        ]);
        
        return back()->with('success', 'Aplikasi Mitra telah ditolak.');
    }
}
