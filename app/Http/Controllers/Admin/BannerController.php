<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->paginate(15);
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'image'     => 'required|image|max:2048',
            'link'      => 'nullable|url',
            'order'     => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title'     => $request->title,
            'image'     => $path,
            'link'      => $request->link,
            'order'     => $request->input('order', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'image'     => 'nullable|image|max:2048',
            'link'      => 'nullable|url',
            'order'     => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $banner = Banner::findOrFail($id);

        $data = [
            'title'     => $request->title,
            'link'      => $request->link,
            'order'     => $request->input('order', 0),
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        Storage::disk('public')->delete($banner->image);
        $banner->delete();
        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil dihapus.');
    }

    public function toggle(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['is_active' => !$banner->is_active]);
        return back()->with('success', 'Status banner berhasil diubah.');
    }
}