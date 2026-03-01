@extends('layouts.dashboard')

@section('title', 'Verifikasi UMKM')

@section('dashboard-content')
<div class="page-header">
    <h1 class="page-title">Verifikasi UMKM</h1>
    <p class="page-sub">Kelola pengajuan UMKM yang menunggu verifikasi</p>
</div>

<div style="display:flex;gap:16px;margin-bottom:24px;">
    <div style="background:#fff;border:1.5px solid #e5e7eb;border-radius:12px;padding:20px 24px;flex:1;">
        <div style="font-size:13px;color:#9ca3af;margin-bottom:4px">Menunggu Verifikasi</div>
        <div style="font-size:28px;font-weight:800;color:#f59e0b">{{ $pending->total() }}</div>
    </div>
    <div style="background:#fff;border:1.5px solid #e5e7eb;border-radius:12px;padding:20px 24px;flex:1;">
        <div style="font-size:13px;color:#9ca3af;margin-bottom:4px">Ditolak</div>
        <div style="font-size:28px;font-weight:800;color:#ef4444">{{ $rejected->total() }}</div>
    </div>
</div>

{{-- PENDING --}}
<div style="background:#fff;border:1.5px solid #e5e7eb;border-radius:14px;overflow:hidden;margin-bottom:32px;">
    <div style="padding:20px 24px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;">
        <h2 style="font-size:16px;font-weight:700;color:#111827">Menunggu Verifikasi</h2>
        <span style="font-size:13px;color:#9ca3af">{{ $pending->total() }} pengajuan</span>
    </div>

    @if($pending->count() > 0)
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f9fafb;">
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">UMKM</th>
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">Pemilik</th>
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">Kategori</th>
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">Kecamatan</th>
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">Tanggal Daftar</th>
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pending as $umkm)
                <tr style="border-top:1px solid #f0f0f0;">
                    <td style="padding:14px 16px;">
                        <div style="font-size:14px;font-weight:600;color:#111827;">{{ $umkm->name }}</div>
                        @if($umkm->address)
                            <div style="font-size:12px;color:#9ca3af;margin-top:2px;">{{ Str::limit($umkm->address, 40) }}</div>
                        @endif
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="font-size:14px;color:#374151;">{{ $umkm->user->name ?? '-' }}</div>
                        <div style="font-size:12px;color:#9ca3af;">{{ $umkm->user->email ?? '' }}</div>
                    </td>
                    <td style="padding:14px 16px;">
                        <span style="font-size:12px;background:#f0fdf4;color:#16a34a;padding:3px 10px;border-radius:100px;font-weight:600;">
                            {{ $umkm->category->name ?? '-' }}
                        </span>
                    </td>
                    <td style="padding:14px 16px;font-size:14px;color:#374151;">{{ $umkm->kecamatan ?? '-' }}</td>
                    <td style="padding:14px 16px;font-size:13px;color:#6b7280;">{{ $umkm->created_at->format('d M Y') }}</td>
                    <td style="padding:14px 16px;">
                        <div style="display:flex;gap:8px;">
                            <form action="{{ route('admin.verifikasi.approve', $umkm) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" onclick="return confirm('Setujui UMKM ini?')"
                                    style="background:#16a34a;color:#fff;border:none;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                    ✓ Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.verifikasi.reject', $umkm) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" onclick="return confirm('Tolak UMKM ini?')"
                                    style="background:#ef4444;color:#fff;border:none;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                    ✗ Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding:16px 24px;">{{ $pending->links() }}</div>
    @else
    <div style="text-align:center;padding:48px;color:#9ca3af;">
        <div style="font-size:40px;margin-bottom:12px;">✅</div>
        <div style="font-size:15px;font-weight:600;color:#374151;">Tidak ada pengajuan pending</div>
    </div>
    @endif
</div>

{{-- DITOLAK --}}
<div style="background:#fff;border:1.5px solid #e5e7eb;border-radius:14px;overflow:hidden;">
    <div style="padding:20px 24px;border-bottom:1px solid #f0f0f0;">
        <h2 style="font-size:16px;font-weight:700;color:#111827">UMKM Ditolak</h2>
    </div>
    @if($rejected->count() > 0)
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f9fafb;">
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">UMKM</th>
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">Pemilik</th>
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">Kategori</th>
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">Tanggal</th>
                    <th style="padding:12px 16px;text-align:left;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rejected as $umkm)
                <tr style="border-top:1px solid #f0f0f0;">
                    <td style="padding:14px 16px;font-size:14px;font-weight:600;color:#111827;">{{ $umkm->name }}</td>
                    <td style="padding:14px 16px;">
                        <div style="font-size:14px;color:#374151;">{{ $umkm->user->name ?? '-' }}</div>
                        <div style="font-size:12px;color:#9ca3af;">{{ $umkm->user->email ?? '' }}</div>
                    </td>
                    <td style="padding:14px 16px;">
                        <span style="font-size:12px;background:#fef2f2;color:#ef4444;padding:3px 10px;border-radius:100px;font-weight:600;">
                            {{ $umkm->category->name ?? '-' }}
                        </span>
                    </td>
                    <td style="padding:14px 16px;font-size:13px;color:#6b7280;">{{ $umkm->created_at->format('d M Y') }}</td>
                    <td style="padding:14px 16px;">
                        <form action="{{ route('admin.verifikasi.approve', $umkm) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" onclick="return confirm('Setujui UMKM ini?')"
                                style="background:#16a34a;color:#fff;border:none;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                ✓ Setujui Ulang
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding:16px 24px;">{{ $rejected->links() }}</div>
    @else
    <div style="text-align:center;padding:48px;color:#9ca3af;">
        <div style="font-size:15px;font-weight:600;color:#374151;">Tidak ada UMKM yang ditolak</div>
    </div>
    @endif
</div>
@endsection