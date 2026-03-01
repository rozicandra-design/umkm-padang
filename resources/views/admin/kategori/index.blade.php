@extends('layouts.dashboard')
@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

@section('dashboard-content')

@if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;border-left:4px solid #16a34a;border-radius:12px;padding:12px 18px;margin-bottom:20px;color:#166534;font-size:13.5px;font-weight:600;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-tags"></i> Daftar Kategori</h3>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-sm btn-green">
            <i class="fa fa-plus"></i> Tambah Kategori
        </a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah UMKM</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $categories->firstItem() + $loop->index }}</td>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td>
                        <span class="badge badge-blue">{{ $category->umkm_profiles_count }} UMKM</span>
                    </td>
                    <td>
                        <span class="badge {{ $category->is_active ? 'badge-green' : 'badge-red' }}">
                            {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="{{ route('admin.kategori.edit', $category->id) }}" class="btn btn-sm btn-outline-amber">Edit</a>
                        <form action="{{ route('admin.kategori.destroy', $category->id) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm"
                                    style="background:#fee2e2;color:#dc2626;border:1px solid #fecaca;"
                                    {{ $category->umkm_profiles_count > 0 ? 'disabled title=Tidak bisa dihapus, masih ada UMKM' : '' }}>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted" style="padding:32px;">
                        <i class="fa fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4;"></i>
                        Belum ada kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #e5e7eb;">
        {{ $categories->links() }}
    </div>
    @endif
</div>

@endsection