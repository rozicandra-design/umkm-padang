<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        $pending  = UmkmProfile::pending()->with('user','category')->latest()->paginate(10);
        $rejected = UmkmProfile::where('status','rejected')->with('user','category')->latest()->paginate(10);
        return view('admin.verifikasi', compact('pending','rejected'));
    }

    public function approve(UmkmProfile $umkm)
    {
        $umkm->update(['status' => 'active', 'verified_at' => now()]);
        // Notifikasi ke pemilik UMKM
       //$umkm->user->notify(new \App\Notifications\UmkmApproved($umkm));
        return back()->with('success', "UMKM \"{$umkm->name}\" berhasil diverifikasi.");
    }

    public function reject(Request $request, UmkmProfile $umkm)
    {
        $request->validate(['alasan' => 'nullable|string|max:500']);
        $umkm->update(['status' => 'rejected']);
        return back()->with('success', "UMKM \"{$umkm->name}\" ditolak.");
    }
}
