@extends('layouts.dashboard')
@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')

@section('dashboard-content')
<div class="card" style="max-width:700px">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-plus-circle"></i> Form Tambah Produk</h3>
        <a href="{{ route('umkm.produk.index') }}" class="btn btn-sm btn-outline-blue">← Kembali</a>
    </div>
    <div style="padding:24px">
        <form action="{{ route('umkm.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Produk *</label>
                    <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required placeholder="Nama produk Anda">
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori *</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Produk</label>
                <textarea name="description" class="form-textarea" rows="3"
                    placeholder="Jelaskan produk Anda...">{{ old('description') }}</textarea>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Harga (Rp) *</label>
                    <input type="number" name="price" class="form-input @error('price') is-invalid @enderror"
                        value="{{ old('price') }}" required min="0" placeholder="Contoh: 50000">
                    @error('price')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Stok *</label>
                    <input type="number" name="stock" class="form-input @error('stock') is-invalid @enderror"
                        value="{{ old('stock', 0) }}" required min="0">
                    @error('stock')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="unit" class="form-input" value="{{ old('unit', 'pcs') }}" placeholder="pcs / kg / lusin">
                </div>
                <div class="form-group">
                    <label class="form-label">Min. Pembelian</label>
                    <input type="number" name="min_order" class="form-input" value="{{ old('min_order', 1) }}" min="1">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Foto Produk</label>
                <input type="file" name="images[]" class="form-input" multiple accept="image/*">
                <div style="font-size:12px;color:#6B7A90;margin-top:4px">Bisa upload lebih dari 1 foto (max 2MB per foto)</div>
            </div>

            <div style="display:flex;gap:12px;margin-top:8px">
                <button type="submit" class="btn btn-blue"><i class="fa fa-save"></i> Simpan Produk</button>
                <a href="{{ route('umkm.produk.index') }}" class="btn btn-outline-blue">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
