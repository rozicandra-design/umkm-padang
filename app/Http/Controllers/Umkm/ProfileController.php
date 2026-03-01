<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\UmkmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private function getUmkm()
    {
        return Auth::user()->umkmProfile;
    }

    public function edit()
    {
        $user       = Auth::user();
        $umkm       = $this->getUmkm();
        $categories = UmkmCategory::orderBy('name')->get();

        return view('umkm.profil.edit', compact('user', 'umkm', 'categories'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $umkm = $this->getUmkm();

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:umkm_categories,id',
            'kecamatan'   => 'required|string|max:100',
            'address'     => 'required|string|max:500',
            'description' => 'nullable|string|max:1000',
            'whatsapp'    => 'nullable|string|max:20',
            'instagram'   => 'nullable|string|max:100',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($umkm) {
            $data = [
                'name'        => $request->name,
                'category_id' => $request->category_id,
                'kecamatan'   => $request->kecamatan,
                'address'     => $request->address,
                'description' => $request->description,
                'whatsapp'    => $request->whatsapp,
                'instagram'   => $request->instagram,
                'latitude'    => $request->latitude,
                'longitude'   => $request->longitude,
            ];

            if ($request->hasFile('logo')) {
                if ($umkm->logo) {
                    Storage::disk('public')->delete($umkm->logo);
                }
                $data['logo'] = $request->file('logo')->store('umkm/logos', 'public');
            }

            $umkm->update($data);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}