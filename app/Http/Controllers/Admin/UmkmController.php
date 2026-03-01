<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use App\Models\UmkmCategory;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index()
    {
        $umkmList = UmkmProfile::with('category', 'user')->paginate(15);
        return view('admin.umkm.index', compact('umkmList'));
    }

    public function show(string $id)
    {
        $umkm = UmkmProfile::with('category', 'user', 'products')->findOrFail($id);
        return view('admin.umkm.show', compact('umkm'));
    }

    public function edit(string $id)
    {
        $umkm       = UmkmProfile::findOrFail($id);
        $categories = UmkmCategory::where('is_active', true)->get();
        return view('admin.umkm.edit', compact('umkm', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        $umkm->update($request->all());
        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        UmkmProfile::findOrFail($id)->delete();
        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil dihapus.');
    }
}