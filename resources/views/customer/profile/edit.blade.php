@extends('layouts.dashboard')
@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('dashboard-content')
<div class="card" style="max-width:600px">
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
@endsection
