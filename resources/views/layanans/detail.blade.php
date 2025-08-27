@extends('layouts.app2')

@section('title', 'Detail Barang')

@section('content')
    <div class="container my-5">
        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success shadow-sm rounded-3">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger shadow-sm rounded-3">{{ session('error') }}</div>
        @endif

        <!-- Card Detail Layanan -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-primary bg-gradient text-white
                            d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-gear fs-2"></i>
                    </div>
                    <h3 class="fw-bold text-dark">{{ $layanan->nama_layanan }}</h3>
                </div>

                <!-- Info Layanan -->
                <div class="mb-3">
                    <h6 class="text-muted mb-1">Deskripsi</h6>
                    <p class="fs-6">{{ $layanan->deskripsi }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted mb-1">Durasi</h6>
                    <span class="badge bg-info text-dark fs-6">
                        ⏱ {{ $layanan->durasi }} menit
                    </span>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted mb-1">Harga</h6>
                    <p class="fw-bold text-success fs-4 mb-0">
                        Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Tombol -->
                <div class="d-flex gap-2">
                    <a href="{{ route('index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left"></i> Kembali ke Etalase
                    </a>
                    <a href="#" class="btn btn-primary px-4">
                        <i class="bi bi-cart-plus"></i> Pesan Layanan
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
