@extends('layouts.dashboard')
@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')

@section('dashboard-content')
<div class="card">
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

            {{-- FOTO PRODUK + PREVIEW --}}
            <div class="form-group">
                <label class="form-label">Foto Produk</label>

                <label for="fotoInput" style="
                    display:flex; align-items:center; gap:10px;
                    border:2px dashed #cbd5e1; border-radius:10px;
                    padding:16px 20px; cursor:pointer;
                    background:#f8fafc; transition:border-color .2s;
                " onmouseover="this.style.borderColor='#3b6cf7'" onmouseout="this.style.borderColor='#cbd5e1'">
                    <i class="fa fa-cloud-upload" style="font-size:22px;color:#3b6cf7"></i>
                    <div>
                        <div style="font-weight:600;font-size:13.5px;color:#1e293b">Pilih Foto Produk</div>
                        <div style="font-size:12px;color:#94a3b8">Bisa pilih lebih dari 1 foto · Max 2MB per foto</div>
                    </div>
                </label>
                <input type="file" name="images[]" id="fotoInput" multiple accept="image/*"
                    style="display:none" onchange="previewFoto(this)">

                {{-- Area Preview --}}
                <div id="previewContainer" style="
                    display:flex; flex-wrap:wrap; gap:12px; margin-top:14px;
                "></div>
            </div>

            <div style="display:flex;gap:12px;margin-top:8px">
                <button type="submit" class="btn btn-blue"><i class="fa fa-save"></i> Simpan Produk</button>
                <a href="{{ route('umkm.produk.index') }}" class="btn btn-outline-blue">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewFoto(input) {
    const container = document.getElementById('previewContainer');
    container.innerHTML = '';

    if (!input.files || input.files.length === 0) return;

    Array.from(input.files).forEach((file, index) => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const wrap = document.createElement('div');
            wrap.style.cssText = `
                position:relative; width:110px; height:110px;
                border-radius:10px; overflow:hidden;
                border:2px solid #e2e8f0; box-shadow:0 2px 8px rgba(0,0,0,0.08);
            `;

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;';

            // Badge nomor foto
            const badge = document.createElement('div');
            badge.style.cssText = `
                position:absolute; bottom:5px; left:5px;
                background:rgba(0,0,0,0.55); color:#fff;
                font-size:10px; font-weight:600;
                padding:2px 6px; border-radius:20px;
            `;
            badge.textContent = 'Foto ' + (index + 1);

            // Tombol hapus
            const del = document.createElement('button');
            del.type = 'button';
            del.innerHTML = '&times;';
            del.style.cssText = `
                position:absolute; top:4px; right:4px;
                background:rgba(239,68,68,0.85); color:#fff;
                border:none; border-radius:50%;
                width:20px; height:20px; font-size:14px;
                cursor:pointer; line-height:1; padding:0;
                display:flex; align-items:center; justify-content:center;
            `;
            del.onclick = function() { wrap.remove(); };

            wrap.appendChild(img);
            wrap.appendChild(badge);
            wrap.appendChild(del);
            container.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endpush
@endsection