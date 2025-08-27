@extends('layouts.app2')

@section('title', 'Detail Barang')

@section('content')
    <div class="container my-5">
        @if (session('success'))
            <div class="alert alert-success shadow-sm rounded-pill px-4">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger shadow-sm rounded-pill px-4">{{ session('error') }}</div>
        @endif

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="row g-0">
                {{-- Gambar Produk --}}
                <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4">
                    @if ($barang->foto)
                        <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama }}"
                            class="img-fluid rounded-3" style="max-height: 350px; object-fit: contain;">
                    @else
                        <div class="text-muted">Tidak ada foto produk</div>
                    @endif
                </div>

                {{-- Informasi Produk --}}
                <div class="col-md-7 p-4">
                    <h2 class="fw-bold">{{ $barang->nama }}</h2>
                    <p class="text-success fs-4 fw-semibold mt-2">
                        Rp{{ number_format($barang->harga, 0, ',', '.') }}
                    </p>
                    <p class="text-muted mb-4">{{ $barang->deskripsi }}</p>

                    @if (isset($barang->stok))
                        <p class="mb-1">
                            <span class="badge bg-info text-dark">Stok: {{ $barang->stok }}</span>
                        </p>
                    @endif

                    @auth
                        {{-- Form Tambah ke Keranjang / Beli --}}
                        <form action="{{ route('keranjang.tambah') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                            <div class="d-flex align-items-center mb-3">
                                <label for="jumlah" class="me-2 fw-semibold">Jumlah:</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control w-auto" value="1"
                                    min="1" max="{{ $barang->stok ?? 99 }}" required>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" name="action" value="keranjang"
                                    class="btn btn-primary btn-lg flex-fill shadow-sm">
                                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                </button>
                                <button type="submit" name="action" value="beli"
                                    class="btn btn-success btn-lg flex-fill shadow-sm">
                                    <i class="bi bi-lightning-charge"></i> Beli Sekarang
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning mt-4 rounded-3 shadow-sm">
                            Silakan <a href="{{ route('login') }}" class="fw-bold">login</a> untuk memesan barang.
                        </div>
                    @endauth

                    <div class="mt-4">
                        <a href="{{ route('index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Etalase
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
