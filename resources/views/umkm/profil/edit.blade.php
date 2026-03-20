@extends('layouts.dashboard')
@section('title', 'Profil Toko')
@section('page-title', 'Edit Profil Toko')

@section('dashboard-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-store"></i> Informasi Toko</h3>
        @if(auth()->user()->umkmProfile)
        <a href="{{ route('umkm.show', auth()->user()->umkmProfile->slug) }}" target="_blank" class="btn btn-sm btn-outline-blue">
            Lihat Profil Publik ↗
        </a>
        @endif
    </div>
    <div style="padding:24px">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(!auth()->user()->umkmProfile)
        <div class="alert alert-warning">Profil UMKM belum dibuat. Silakan isi form berikut.</div>
        @endif

        <form action="{{ route('umkm.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Nama UMKM *</label>
                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                    value="{{ old('name', $umkm->name ?? '') }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Kategori *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $umkm->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kecamatan *</label>
                    <select name="kecamatan" class="form-select" required>
                        @foreach(['Bungus Teluk Kabung','Koto Tangah','Kuranji','Lubuk Begalung','Lubuk Kilangan','Nanggalo','Padang Barat','Padang Selatan','Padang Timur','Padang Utara','Pauh'] as $kec)
                        <option value="{{ $kec }}"
                            {{ old('kecamatan', $umkm->kecamatan ?? '') == $kec ? 'selected' : '' }}>
                            {{ $kec }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Lengkap *</label>
                <textarea name="address" class="form-textarea" rows="2" required>{{ old('address', $umkm->address ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi UMKM</label>
                <textarea name="description" class="form-textarea" rows="3"
                    placeholder="Ceritakan tentang usaha Anda...">{{ old('description', $umkm->description ?? '') }}</textarea>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-input"
                        value="{{ old('whatsapp', $umkm->whatsapp ?? '') }}" placeholder="08xx-xxxx-xxxx">
                </div>
                <div class="form-group">
                    <label class="form-label">Instagram</label>
                    <input type="text" name="instagram" class="form-input"
                        value="{{ old('instagram', $umkm->instagram ?? '') }}" placeholder="@username">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Latitude (GPS)</label>
                    <input type="text" name="latitude" class="form-input"
                        value="{{ old('latitude', $umkm->latitude ?? '') }}" placeholder="-0.9492">
                </div>
                <div class="form-group">
                    <label class="form-label">Longitude (GPS)</label>
                    <input type="text" name="longitude" class="form-input"
                        value="{{ old('longitude', $umkm->longitude ?? '') }}" placeholder="100.3543">
                </div>
            </div>

            {{-- LOGO / FOTO TOKO + PREVIEW --}}
            <div class="form-group">
                <label class="form-label">Logo / Foto Toko</label>

                <label for="logoInput" style="
                    display:flex; align-items:center; gap:10px;
                    border:2px dashed #cbd5e1; border-radius:10px;
                    padding:16px 20px; cursor:pointer;
                    background:#f8fafc; transition:border-color .2s;
                " onmouseover="this.style.borderColor='#3b6cf7'" onmouseout="this.style.borderColor='#cbd5e1'">
                    <i class="fa fa-cloud-upload" style="font-size:22px;color:#3b6cf7"></i>
                    <div>
                        <div style="font-weight:600;font-size:13.5px;color:#1e293b">Pilih Logo / Foto Toko</div>
                        <div style="font-size:12px;color:#94a3b8">Format JPG, PNG · Max 2MB</div>
                    </div>
                </label>
                <input type="file" name="logo" id="logoInput" accept="image/*"
                    style="display:none" onchange="previewLogo(this)">

                {{-- Preview: tampilkan foto lama jika ada, diganti kalau pilih baru --}}
                <div style="margin-top:12px">
                    <img id="logoPreview"
                        src="{{ (isset($umkm) && $umkm->logo) ? asset('storage/'.$umkm->logo) : '' }}"
                        style="height:100px; border-radius:10px; border:2px solid #e2e8f0;
                               object-fit:cover; display:{{ (isset($umkm) && $umkm->logo) ? 'block' : 'none' }};">
                </div>
            </div>

            <button type="submit" class="btn btn-blue"><i class="fa fa-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    if (!input.files || input.files.length === 0) return;

    const file = input.files[0];
    if (!file.type.startsWith('image/')) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
@endsection