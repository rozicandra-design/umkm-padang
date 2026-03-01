@extends('layouts.dashboard')
@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('dashboard-content')

@if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;border-left:4px solid #16a34a;border-radius:12px;padding:12px 18px;margin-bottom:20px;color:#166534;font-size:13.5px;font-weight:600;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-users"></i> Daftar Pengguna</h3>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @php
                            $roleColor = match($user->role) {
                                'admin'    => 'purple',
                                'umkm'     => 'green',
                                'customer' => 'blue',
                                'dinas'    => 'amber',
                                default    => 'gray',
                            };
                        @endphp
                        <span class="badge badge-{{ $roleColor }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-red' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="{{ route('admin.pengguna.edit', $user->id) }}" class="btn btn-sm btn-outline-amber">Edit</a>
                        <form action="{{ route('admin.pengguna.toggle', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-gray">
                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus pengguna ini?')">
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
                        Belum ada data pengguna
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #e5e7eb;">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection