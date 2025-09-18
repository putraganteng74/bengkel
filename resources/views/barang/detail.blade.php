@extends('layouts.app')

@section('title', 'Detail Barang - Bengkel Kasnoto Motor')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-semibold text-primary">
                            <i class="fas fa-box-open me-2"></i> Detail Barang
                        </h4>
                        <a href="{{ route('barang.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($barang->foto)
                            <div class="mb-4 text-center">
                                <img src="{{ asset('storage/' . $barang->foto) }}" class="img-fluid rounded shadow-sm"
                                    style="max-height: 280px; object-fit: cover;" alt="{{ $barang->nama }}">
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="text-muted mb-1">Nama Barang</h6>
                                    <p class="fw-bold mb-0">{{ $barang->nama }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="text-muted mb-1">Jenis Barang</h6>
                                    <p class="fw-bold mb-0">{{ $barang->jenisBarang->jenis ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="text-muted mb-1">Harga</h6>
                                    <p class="fw-bold text-success mb-0">Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="text-muted mb-1">Stok</h6>
                                    <p class="fw-bold mb-0">{{ $barang->stok }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="text-muted mb-1">Deskripsi</h6>
                                    <p class="mb-0">{{ $barang->deskripsi ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
