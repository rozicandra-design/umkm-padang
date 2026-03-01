@extends('layouts.dashboard')
@section('title', 'Kelola UMKM')
@section('page-title', 'Kelola UMKM')

@section('dashboard-content')

@if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;border-left:4px solid #16a34a;border-radius:12px;padding:12px 18px;margin-bottom:20px;color:#166534;font-size:13.5px;font-weight:600;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-store"></i> Daftar UMKM</h3>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama UMKM</th>
                    <th>Kategori</th>
                    <th>Pemilik</th>
                    <th>Kecamatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($umkmList as $umkm)
                <tr>
                    <td>{{ $umkmList->firstItem() + $loop->index }}</td>
                    <td>{{ $umkm->name }}</td>
                    <td>{{ $umkm->category->name ?? '-' }}</td>
                    <td>{{ $umkm->user->name ?? '-' }}</td>
                    <td>{{ $umkm->kecamatan ?? '-' }}</td>
                    <td>
                        @php
                            $color = match($umkm->status) {
                                'active'   => 'green',
                                'pending'  => 'amber',
                                'inactive' => 'red',
                                default    => 'gray',
                            };
                            $label = match($umkm->status) {
                                'active'   => 'Aktif',
                                'pending'  => 'Menunggu',
                                'inactive' => 'Nonaktif',
                                default    => ucfirst($umkm->status),
                            };
                        @endphp
                        <span class="badge badge-{{ $color }}">{{ $label }}</span>
                    </td>
                    <td style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="btn btn-sm btn-outline-blue">Detail</a>
                        <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="btn btn-sm btn-outline-amber">Edit</a>
                        <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus UMKM ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border:1px solid #fecaca;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted" style="padding:32px;">
                        <i class="fa fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4;"></i>
                        Belum ada data UMKM
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($umkmList->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #e5e7eb;">
        {{ $umkmList->links() }}
    </div>
    @endif
</div>

@endsection