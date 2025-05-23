@extends('layouts.app')

@section('title', 'Detail Barang - Bengkel Kasnoto Motor')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Barang</h5>
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    @if ($barang->foto)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/' . $barang->foto) }}" class="img-fluid rounded" style="max-height: 250px;" alt="{{ $barang->nama }}">
                        </div>
                    @endif
                    <div class="mb-3">
                        <h6 class="text-muted">Nama Barang</h6>
                        <p class="fw-bold">{{ $barang->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted">Deskripsi</h6>
                        <p>{{ $barang->deskripsi }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted">Jenis Barang</h6>
                        <p>{{ $barang->jenisBarang->jenis ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted">Harga</h6>
                        <p>Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted">Stok</h6>
                        <p>{{ $barang->stok }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
