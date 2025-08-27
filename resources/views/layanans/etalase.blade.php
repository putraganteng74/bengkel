@extends('layouts.app2')

@section('title', 'Etalase Layanan')

@section('content')
    <section id="layanan" class="py-5 bg-light">
        <div class="container">
            <!-- Section Header -->
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark mb-3">💼 Layanan Kami</h2>
                <p class="text-muted fs-5">
                    Pilih layanan terbaik yang kami siapkan khusus untuk kebutuhan Anda
                </p>
            </div>

            <!-- Layanan Grid -->
            <div class="row g-4">
                @foreach ($layanans as $layanan)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <a href="{{ route('layanan.detail', $layanan->id) }}" class="text-decoration-none d-block h-100">
                            <div class="card border-0 shadow-sm h-100 text-center p-4 rounded-4 service-card">
                                <!-- Ikon -->
                                <div class="rounded-circle bg-primary bg-gradient text-white
                                        d-flex align-items-center justify-content-center mx-auto mb-3"
                                    style="width: 70px; height: 70px;">
                                    <i class="bi bi-briefcase fs-3"></i>
                                </div>

                                <!-- Nama Layanan -->
                                <h5 class="fw-bold text-dark mb-2">{{ $layanan->nama_layanan }}</h5>

                                <!-- Deskripsi Singkat -->
                                <p class="text-muted small mb-3">{{ Str::limit($layanan->deskripsi, 60) }}</p>

                                <!-- Durasi -->
                                <span class="badge bg-info text-dark mb-2">
                                    ⏱ {{ $layanan->durasi }} menit
                                </span>

                                <!-- Harga -->
                                <p class="fw-bold text-success fs-5 mb-0">
                                    Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .service-card {
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }
    </style>

@endsection
