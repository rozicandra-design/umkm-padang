@extends('layouts.dashboard')
@section('title', 'Kelola Banner')
@section('page-title', 'Kelola Banner')

@section('dashboard-content')

@if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;border-left:4px solid #16a34a;border-radius:12px;padding:12px 18px;margin-bottom:20px;color:#166534;font-size:13.5px;font-weight:600;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-image"></i> Daftar Banner</h3>
        <a href="{{ route('admin.banner.create') }}" class="btn btn-sm btn-green">
            <i class="fa fa-plus"></i> Tambah Banner
        </a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Link</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                <tr>
                    <td>{{ $banners->firstItem() + $loop->index }}</td>
                    <td>
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}"
                             style="width:80px;height:45px;object-fit:cover;border-radius:6px;border:1px solid #e5e7eb;">
                    </td>
                    <td><strong>{{ $banner->title }}</strong></td>
                    <td>
                        @if($banner->link)
                            <a href="{{ $banner->link }}" target="_blank" style="color:#2563eb;font-size:12px;">
                                {{ Str::limit($banner->link, 30) }}
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $banner->order }}</td>
                    <td>
                        <span class="badge {{ $banner->is_active ? 'badge-green' : 'badge-red' }}">
                            {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="display:flex;gap:6px;flex-wrap:wrap;">
                        <form action="{{ route('admin.banner.toggle', $banner->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-gray">
                                {{ $banner->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-sm btn-outline-amber">Edit</a>
                        <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus banner ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border:1px solid #fecaca;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted" style="padding:32px;">
                        <i class="fa fa-image" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4;"></i>
                        Belum ada banner
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($banners->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #e5e7eb;">
        {{ $banners->links() }}
    </div>
    @endif
</div>

@endsection