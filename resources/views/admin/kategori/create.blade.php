@extends('layouts.dashboard')
@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('dashboard-content')

<div class="card" style="max-width:600px;">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-plus"></i> Tambah Kategori</h3>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-outline-gray">Kembali</a>
    </div>
    <div style="padding:24px;">
        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       style="width:100%;padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13.5px;outline:none;"
                       placeholder="Contoh: Makanan & Minuman">
                @error('name') <p style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Deskripsi</label>
                <textarea name="description" rows="3"
                          style="width:100%;padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13.5px;outline:none;resize:vertical;"
                          placeholder="Deskripsi singkat kategori...">{{ old('description') }}</textarea>
            </div>

            <div style="margin-bottom:24px;display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="is_active" value="1" id="is_active"
                       {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active" style="font-size:13px;font-weight:600;color:#374151;cursor:pointer;">Aktif</label>
            </div>

            <button type="submit" class="btn btn-md btn-green">
                <i class="fa fa-save"></i> Simpan
            </button>
        </form>
    </div>
</div>

@endsection