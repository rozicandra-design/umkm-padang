@extends('layouts.dashboard')
@section('title', 'Edit Banner')
@section('page-title', 'Edit Banner')

@section('dashboard-content')

<div class="card" style="max-width:600px;">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-edit"></i> Edit Banner</h3>
        <a href="{{ route('admin.banner.index') }}" class="btn btn-sm btn-outline-gray">Kembali</a>
    </div>
    <div style="padding:24px;">
        <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Judul Banner</label>
                <input type="text" name="title" value="{{ old('title', $banner->title) }}"
                       style="width:100%;padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13.5px;">
                @error('title') <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Gambar Sekarang</label>
                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}"
                     style="width:160px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;display:block;margin-bottom:8px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Ganti Gambar <span style="color:#6b7280;font-weight:400;">(opsional, maks. 2MB)</span></label>
                <input type="file" name="image" accept="image/*"
                       style="width:100%;padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;">
                @error('image') <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Link <span style="color:#6b7280;font-weight:400;">(opsional)</span></label>
                <input type="url" name="link" value="{{ old('link', $banner->link) }}"
                       style="width:100%;padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13.5px;"
                       placeholder="https://...">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Urutan</label>
                <input type="number" name="order" value="{{ old('order', $banner->order) }}" min="0"
                       style="width:120px;padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13.5px;">
            </div>

            <div style="margin-bottom:24px;display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="is_active" value="1" id="is_active"
                       {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                <label for="is_active" style="font-size:13px;font-weight:600;color:#374151;cursor:pointer;">Aktif</label>
            </div>

            <button type="submit" class="btn btn-md btn-green">
                <i class="fa fa-save"></i> Update
            </button>
        </form>
    </div>
</div>

@endsection