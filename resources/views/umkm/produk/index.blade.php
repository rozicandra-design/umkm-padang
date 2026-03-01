@extends('layouts.dashboard')
@section('title', 'Produk Saya')
@section('page-title', 'Produk Saya')

@section('dashboard-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-box"></i> Daftar Produk</h3>
        <a href="{{ route('umkm.produk.create') }}" class="btn btn-blue btn-sm">
            <i class="fa fa-plus"></i> Tambah Produk
        </a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <strong>{{ $product->name }}</strong><br>
                        <small style="color:#6B7A90">{{ Str::limit($product->description, 50) }}</small>
                    </td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }} {{ $product->unit }}</td>
                    <td>
                        <span class="badge badge-{{ $product->is_available ? 'success' : 'secondary' }}">
                            {{ $product->is_available ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="display:flex;gap:6px;flex-wrap:wrap">
                        <a href="{{ route('umkm.produk.edit', $product) }}" class="btn btn-sm btn-outline-blue">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('umkm.produk.toggle', $product) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm {{ $product->is_available ? 'btn-warning' : 'btn-success' }}" title="{{ $product->is_available ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <i class="fa fa-{{ $product->is_available ? 'eye-slash' : 'eye' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('umkm.produk.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted" style="padding:32px">
                        Belum ada produk. <a href="{{ route('umkm.produk.create') }}" style="color:#1553A8">Tambah sekarang →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px">{{ $products->links() }}</div>
</div>
@endsection
