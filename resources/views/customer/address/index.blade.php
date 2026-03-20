@extends('layouts.dashboard')
@section('title', 'Alamat Saya')
@section('page-title', 'Alamat Saya')

@section('dashboard-content')

<div style="padding: 0;">

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:20px;">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
            <button onclick="this.parentElement.remove()" class="alert-close">&times;</button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-error" style="margin-bottom:20px;">
            <i class="fa fa-times-circle"></i> {{ $errors->first() }}
            <button onclick="this.parentElement.remove()" class="alert-close">&times;</button>
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start;">

        {{-- Form Tambah --}}
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;">
            <h3 style="font-size:15px;font-weight:700;color:#111827;margin:0 0 20px;display:flex;align-items:center;gap:8px;">
                <i class="fa fa-plus-circle" style="color:#16a34a;"></i> Tambah Alamat Baru
            </h3>

            <form action="{{ route('customer.address.store') }}" method="POST">
                @csrf

                <div style="margin-bottom:14px;">
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">
                        Label Alamat <span style="color:#9ca3af;font-weight:400;">(Rumah, Kantor, dll)</span>
                    </label>
                    <input type="text" name="label" placeholder="contoh: Rumah"
                           value="{{ old('label') }}"
                           style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;font-family:inherit;"
                           onfocus="this.style.borderColor='#16a34a'" onblur="this.style.borderColor='#e5e7eb'">
                </div>

                <div style="margin-bottom:14px;">
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">
                        Alamat Lengkap <span style="color:#ef4444;">*</span>
                    </label>
                    <textarea name="address" rows="3" required
                              placeholder="Jl. Nama Jalan No. XX, Kelurahan, Kecamatan"
                              style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;resize:vertical;font-family:inherit;"
                              onfocus="this.style.borderColor='#16a34a'" onblur="this.style.borderColor='#e5e7eb'">{{ old('address') }}</textarea>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Kota</label>
                        <input type="text" name="city" placeholder="Padang"
                               value="{{ old('city', 'Padang') }}"
                               style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;font-family:inherit;"
                               onfocus="this.style.borderColor='#16a34a'" onblur="this.style.borderColor='#e5e7eb'">
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Provinsi</label>
                        <input type="text" name="province" placeholder="Sumatera Barat"
                               value="{{ old('province', 'Sumatera Barat') }}"
                               style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;font-family:inherit;"
                               onfocus="this.style.borderColor='#16a34a'" onblur="this.style.borderColor='#e5e7eb'">
                    </div>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Kode Pos</label>
                    <input type="text" name="postal_code" placeholder="25111"
                           value="{{ old('postal_code') }}" maxlength="10"
                           style="width:140px;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;font-family:inherit;"
                           onfocus="this.style.borderColor='#16a34a'" onblur="this.style.borderColor='#e5e7eb'">
                </div>

                <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
                    <input type="checkbox" name="is_default" id="is_default" value="1"
                           {{ old('is_default') ? 'checked' : '' }}
                           style="width:16px;height:16px;accent-color:#16a34a;cursor:pointer;">
                    <label for="is_default" style="font-size:13px;color:#374151;font-weight:500;cursor:pointer;">
                        Jadikan alamat utama
                    </label>
                </div>

                <button type="submit"
                        style="background:#16a34a;color:#fff;font-size:13px;font-weight:700;padding:10px 24px;border:none;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;"
                        onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                    <i class="fa fa-save"></i> Simpan Alamat
                </button>
            </form>
        </div>

        {{-- Daftar Alamat --}}
        <div>
            <h3 style="font-size:15px;font-weight:700;color:#111827;margin:0 0 14px;display:flex;align-items:center;gap:8px;">
                <i class="fa fa-map-marker-alt" style="color:#16a34a;"></i>
                Alamat Tersimpan
                <span style="font-size:12px;background:#f3f4f6;color:#6b7280;padding:2px 8px;border-radius:99px;font-weight:600;">
                    {{ $addresses->count() }}
                </span>
            </h3>

            @forelse($addresses as $addr)
            <div style="background:{{ $addr->is_default ? '#f0fdf4' : '#fff' }};border:1.5px solid {{ $addr->is_default ? '#16a34a' : '#e5e7eb' }};border-radius:12px;padding:16px;margin-bottom:10px;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;">
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:13px;font-weight:700;color:#111827;display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                            <i class="fa fa-tag" style="color:#9ca3af;font-size:11px;"></i>
                            {{ $addr->label ?? 'Alamat' }}
                            @if($addr->is_default)
                                <span style="font-size:10px;font-weight:700;background:#16a34a;color:#fff;padding:1px 8px;border-radius:99px;">Utama</span>
                            @endif
                        </div>
                        <div style="font-size:13px;color:#374151;line-height:1.5;">{{ $addr->address }}</div>
                        @if($addr->city || $addr->province || $addr->postal_code)
                        <div style="font-size:12px;color:#9ca3af;margin-top:3px;">
                            <i class="fa fa-map-pin" style="font-size:10px;"></i>
                            {{ implode(', ', array_filter([$addr->city, $addr->province, $addr->postal_code])) }}
                        </div>
                        @endif
                    </div>
                    <div style="display:flex;flex-direction:column;gap:6px;flex-shrink:0;">
                        @if(!$addr->is_default)
                        <form action="{{ route('customer.address.default', $addr) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    style="font-size:11px;font-weight:600;padding:5px 10px;border-radius:6px;border:1.5px solid #16a34a;color:#16a34a;background:#fff;cursor:pointer;white-space:nowrap;width:100%;"
                                    onmouseover="this.style.background='#16a34a';this.style.color='#fff'"
                                    onmouseout="this.style.background='#fff';this.style.color='#16a34a'">
                                <i class="fa fa-star"></i> Utamakan
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('customer.address.destroy', $addr) }}" method="POST"
                              onsubmit="return confirm('Hapus alamat ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="font-size:11px;font-weight:600;padding:5px 10px;border-radius:6px;border:1.5px solid #ef4444;color:#ef4444;background:#fff;cursor:pointer;white-space:nowrap;width:100%;"
                                    onmouseover="this.style.background='#ef4444';this.style.color='#fff'"
                                    onmouseout="this.style.background='#fff';this.style.color='#ef4444'">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:48px 24px;text-align:center;">
                <div style="font-size:36px;margin-bottom:12px;">📭</div>
                <div style="font-size:14px;font-weight:600;color:#374151;margin-bottom:4px;">Belum ada alamat tersimpan</div>
                <div style="font-size:13px;color:#9ca3af;">Tambahkan alamat pengiriman kamu di sebelah kiri</div>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection