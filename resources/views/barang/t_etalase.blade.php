@extends('layouts.app2')

@section('title', 'Detail Barang')

@section('content')
<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3>{{ $barang->nama }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Harga:</strong> Rp{{ number_format($barang->harga, 0, ',', '.') }}</p>
            <p><strong>Deskripsi:</strong></p>
            <p>{{ $barang->deskripsi }}</p>

            @if ($barang->foto)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama }}" class="img-fluid" style="max-width: 300px;">
                </div>
            @endif
            @auth
                {{-- Form Tambah ke Keranjang dan Beli Sekarang --}}
                <form action="{{ route('keranjang.tambah') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                    <div class="form-group">
                        <label for="jumlah">Jumlah:</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" min="1" max="{{ $barang->stok ?? 99 }}" required>
                    </div>
                    <div class="mt-3">
                        <button type="submit" name="action" value="keranjang" class="btn btn-primary">Tambah ke Keranjang</button>
                        <button type="submit" name="action" value="beli" class="btn btn-success">Beli Sekarang</button>
                    </div>
                </form>
            @else
                <div class="alert alert-warning mt-4">
                    Silakan <a href="{{ route('login') }}">login</a> untuk memesan barang.
                </div>
            @endauth 
        </div>

        <div class="card-footer">
            <a href="{{ route('etalase') }}" class="btn btn-secondary">Kembali ke Etalase</a>
        </div>
    </div>
</div>
@endsection
