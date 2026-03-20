@extends('layouts.dashboard')
@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('dashboard-content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start;">

    {{-- Kolom Kiri: Edit Profil --}}
    <div>
        <div class="card" style="max-width:100%">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-user-edit"></i> Edit Profil Saya</h3>
            </div>
            <div style="padding:24px">
                <form action="{{ route('customer.profil.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                            value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                            value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. HP / WhatsApp</label>
                        <input type="text" name="phone" class="form-input"
                            value="{{ old('phone', auth()->user()->phone) }}" placeholder="08xx-xxxx-xxxx">
                    </div>
                    <div style="border-top:1px solid #E2EAF4;margin:20px 0;padding-top:20px">
                        <h4 style="font-size:14px;font-weight:700;margin-bottom:16px">Ganti Password (opsional)</h4>
                        <div class="form-group">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-input @error('password') is-invalid @enderror"
                                placeholder="Kosongkan jika tidak ingin ganti">
                            @error('password')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password baru">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-blue"><i class="fa fa-save"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Alamat --}}
    <div>
        {{-- Form Tambah Alamat --}}
        <div class="card" style="max-width:100%;margin-bottom:16px;">
            <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;">
                <h3 class="card-title"><i class="fa fa-plus-circle" style="color:#16a34a;"></i> Tambah Alamat</h3>
            </div>
            <div style="padding:20px;">
                @if($errors->has('address'))
                    <div class="alert alert-error" style="margin-bottom:12px;">
                        <i class="fa fa-times-circle"></i> {{ $errors->first('address') }}
                    </div>
                @endif

                <form action="{{ route('customer.address.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Label <span style="color:#9ca3af;font-weight:400;">(Rumah, Kantor, dll)</span></label>
                        <input type="text" name="label" class="form-input" placeholder="Rumah" value="{{ old('label') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap <span style="color:#ef4444;">*</span></label>
                        <textarea name="address" class="form-input" rows="2" required
                                  placeholder="Jl. Nama Jalan No. XX, Kelurahan, Kecamatan"
                                  style="resize:vertical;">{{ old('address') }}</textarea>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div class="form-group">
                            <label class="form-label">Kota</label>
                            <input type="text" name="city" class="form-input" placeholder="Padang" value="{{ old('city', 'Padang') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="province" class="form-input" placeholder="Sumatera Barat" value="{{ old('province', 'Sumatera Barat') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="postal_code" class="form-input" placeholder="25111" value="{{ old('postal_code') }}" maxlength="10" style="max-width:130px;">
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                        <input type="checkbox" name="is_default" id="is_default" value="1"
                               {{ old('is_default') ? 'checked' : '' }}
                               style="width:15px;height:15px;accent-color:#16a34a;cursor:pointer;">
                        <label for="is_default" style="font-size:13px;color:#374151;font-weight:500;cursor:pointer;margin:0;">
                            Jadikan alamat utama
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background:#16a34a;border-color:#16a34a;">
                        <i class="fa fa-save"></i> Simpan Alamat
                    </button>
                </form>
            </div>
        </div>

        {{-- Daftar Alamat Tersimpan --}}
        <div class="card" style="max-width:100%;">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-map-marker-alt" style="color:#16a34a;"></i> Alamat Tersimpan
                    <span style="font-size:12px;background:#f3f4f6;color:#6b7280;padding:2px 8px;border-radius:99px;font-weight:600;margin-left:6px;">
                        {{ auth()->user()->addresses->count() }}
                    </span>
                </h3>
            </div>
            <div style="padding:16px;">
                @forelse(auth()->user()->addresses()->orderByDesc('is_default')->get() as $addr)
                <div style="background:{{ $addr->is_default ? '#f0fdf4' : '#f9fafb' }};border:1.5px solid {{ $addr->is_default ? '#16a34a' : '#e5e7eb' }};border-radius:10px;padding:14px;margin-bottom:10px;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13px;font-weight:700;color:#111827;display:flex;align-items:center;gap:6px;margin-bottom:3px;">
                                <i class="fa fa-tag" style="color:#9ca3af;font-size:11px;"></i>
                                {{ $addr->label ?? 'Alamat' }}
                                @if($addr->is_default)
                                    <span style="font-size:10px;font-weight:700;background:#16a34a;color:#fff;padding:1px 7px;border-radius:99px;">Utama</span>
                                @endif
                            </div>
                            <div style="font-size:12.5px;color:#374151;line-height:1.5;">{{ $addr->address }}</div>
                            @if($addr->city || $addr->province)
                            <div style="font-size:11.5px;color:#9ca3af;margin-top:2px;">
                                {{ implode(', ', array_filter([$addr->city, $addr->province, $addr->postal_code])) }}
                            </div>
                            @endif
                        </div>
                        <div style="display:flex;flex-direction:column;gap:5px;flex-shrink:0;">
                            @if(!$addr->is_default)
                            <form action="{{ route('customer.address.default', $addr) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        style="font-size:11px;font-weight:600;padding:4px 10px;border-radius:6px;border:1.5px solid #16a34a;color:#16a34a;background:#fff;cursor:pointer;width:100%;"
                                        onmouseover="this.style.background='#16a34a';this.style.color='#fff'"
                                        onmouseout="this.style.background='#fff';this.style.color='#16a34a'">
                                    <i class="fa fa-star"></i> Utama
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('customer.address.destroy', $addr) }}" method="POST"
                                  onsubmit="return confirm('Hapus alamat ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        style="font-size:11px;font-weight:600;padding:4px 10px;border-radius:6px;border:1.5px solid #ef4444;color:#ef4444;background:#fff;cursor:pointer;width:100%;"
                                        onmouseover="this.style.background='#ef4444';this.style.color='#fff'"
                                        onmouseout="this.style.background='#fff';this.style.color='#ef4444'">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:32px;color:#9ca3af;font-size:13px;">
                    <div style="font-size:28px;margin-bottom:8px;">📭</div>
                    Belum ada alamat tersimpan
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection