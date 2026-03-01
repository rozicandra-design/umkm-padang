@extends('layouts.dashboard')
@section('title', 'Tambah Banner')
@section('page-title', 'Tambah Banner')

@section('dashboard-content')

<div class="card" style="max-width:600px;">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-plus"></i> Tambah Banner</h3>
        <a href="{{ route('admin.banner.index') }}" class="btn btn-sm btn-outline-gray">Kembali</a>
    </div>
    <div style="padding:24px;">
        <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Judul Banner</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       style="width:100%;padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13.5px;"
                       placeholder="Judul banner...">
                @error('title') <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Gambar <span style="color:#6b7280;font-weight:400;">(maks. 2MB)</span></label>
                <input type="file" name="image" accept="image/*"
                       style="width:100%;padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;">
                @error('image') <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Link <span style="color:#6b7280;font-weight:400;">(opsional)</span></label>
                <input type="url" name="link" value="{{ old('link') }}"
                       style="width:100%;padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13.5px;"
                       placeholder="https://...">
                @error('link') <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Urutan</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                       style="width:120px;padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13.5px;">
            </div>

            <div style="margin-bottom:24px;display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="is_active" value="1" id="is_active" checked>
                <label for="is_active" style="font-size:13px;font-weight:600;color:#374151;cursor:pointer;">Aktif</label>
            </div>

            <button type="submit" class="btn btn-md btn-green">
                <i class="fa fa-save"></i> Simpan
            </button>
        </form>
    </div>
</div>

@endsection