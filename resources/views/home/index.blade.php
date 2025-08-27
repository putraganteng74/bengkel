@extends('layouts.app2')

@section('title', 'Etalase Barang')

@section('content')
    <style>
        #btn-hubungi:hover {
            color: #ea580c !important;
        }
    </style>

    <section id="home" class="pt-5 bg-dark text-light min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center g-5">

                <!-- Text Content -->
                <div class="col-lg-6 text-center text-lg-start">

                    <!-- Badge -->
                    <div class="d-inline-flex align-items-center bg-light bg-opacity-10 rounded-pill px-3 py-2 mb-4">
                        <i class="bi bi-tools text-warning me-2"></i>
                        <span class="small fw-medium">Bengkel Terpercaya #1 di Indonesia</span>
                    </div>

                    <!-- Heading -->
                    <h1 class="display-4 fw-bold mb-4">
                        Layanan Servis Terbaik untuk
                        <span class="d-block text-gradient">Kendaraan Anda</span>
                    </h1>

                    <!-- Description -->
                    <p class="lead mb-4 text-light opacity-75">
                        Kami menyediakan layanan perbaikan dan perawatan kendaraan dengan tenaga ahli berpengalaman,
                        peralatan modern, dan harga yang transparan. Kepuasan serta keamanan Anda adalah prioritas kami.
                    </p>

                    <!-- Buttons -->
                    <div class="d-flex flex-column flex-sm-row gap-3 mb-5">
                        <a href="#layanan" class="btn text-orange btn-light btn-lg fw-semibold shadow">
                            <i class="bi bi-wrench me-2"></i> Booking Servis
                        </a>
                        <a href="#kontak" class="btn btn-outline-light btn-lg">
                            Hubungi Kami
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="row border-top border-light pt-4">
                        <div class="col-4 text-center">
                            <div class="h4 fw-bold">20K+</div>
                            <small class="text-light opacity-75">Pelanggan Puas</small>
                        </div>
                        <div class="col-4 text-center">
                            <div class="h4 fw-bold">15+</div>
                            <small class="text-light opacity-75">Tahun Pengalaman</small>
                        </div>
                        <div class="col-4 text-center">
                            <div class="h4 fw-bold">4.9</div>
                            <small class="text-light opacity-75">Rating Layanan</small>
                        </div>
                    </div>
                </div>


                <!-- Image -->
                <div class="col-lg-6 position-relative">
                    <div class="position-relative z-1">
                        <img src="{{ asset('storage/' . $topProduct->barang->foto) }}" alt="{{ $topProduct->barang->nama }}"
                            class="img-fluid rounded-4 shadow-lg">
                    </div>
                    <!-- Decorative Circles -->
                    <div class="position-absolute top-0 end-0 translate-middle bg-white opacity-25 rounded-circle blur"
                        style="width: 100px; height: 100px;"></div>
                    <div class="position-absolute bottom-0 start-0 translate-middle bg-primary opacity-25 rounded-circle blur"
                        style="width: 130px; height: 130px;"></div>
                </div>

            </div>
        </div>
    </section>

    <section id="categories" class="py-5 bg-light">
        <div class="container">
            <!-- Section Header -->
            <div class="text-center mb-5">
                <h2 class="h2 fw-bold text-dark mb-3">
                    Kategori Produk
                </h2>
                <p class="text-lg text-secondary mx-auto" style="max-width: 600px;">
                    Jelajahi berbagai kategori produk teknologi terkini dengan kualitas terjamin
                </p>
            </div>

            <!-- Categories Slider -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($categories as $category)
                        <div class="swiper-slide">
                            <a href="{{ route('barang.byJenis', $category->slug) }}" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                                    <div class="card-body text-center">

                                        <div class="mb-3 d-flex justify-content-center">
                                            @if ($category->foto)
                                                <img src="{{ asset('storage/' . $category->foto) }}"
                                                    alt="{{ $category->jenis }}" class="rounded-circle"
                                                    style="width:64px; height:64px; object-fit:cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                    style="width:64px;height:64px;">
                                                    <i class="fas fa-image text-white fs-3"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <h5 class="card-title fw-semibold text-dark mb-2">
                                            {{ $category->jenis }}
                                        </h5>

                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>

                <!-- Navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Pagination dots -->
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>

    {{-- Product --}}
    <section id="products" class="py-5 bg-light bg-opacity-25">
        <div class="container">
            <!-- Section Header -->
            <div class="text-center mb-5">
                <span class="badge bg-primary text-white fw-medium mb-3">
                    🔥 Promo Terbatas
                </span>
                <h2 class="h2 fw-bold text-dark mb-3">
                    Produk Diskon Spesial
                </h2>
                <p class="text-lg text-secondary mx-auto" style="max-width: 650px;">
                    Dapatkan penawaran terbaik untuk produk-produk pilihan dengan diskon hingga 50%
                </p>
            </div>

            <!-- Products Grid -->
            <div class="row g-4">
                @foreach ($barangs as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="card h-100 border-0 shadow-sm position-relative overflow-hidden product-card">

                            <!-- Image -->
                            <div class="position-relative overflow-hidden">
                                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}"
                                    class="card-img-top img-fluid product-img" />

                                <!-- Diskon -->
                                @if ($product->diskon > 0)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 fw-bold shadow">
                                        -{{ $product->diskon }}%
                                    </span>
                                @endif

                                <!-- Favorite Button -->
                                <button type="button"
                                    class="btn btn-light btn-sm position-absolute top-0 end-0 m-3 rounded-circle shadow-sm fav-btn">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>

                            <!-- Content -->
                            <div class="card-body">
                                <!-- Category -->
                                <span class="badge bg-light text-secondary mb-2">
                                    {{ $product->jenisBarang->jenis }}
                                </span>

                                <!-- Name -->
                                <h5 class="card-title fw-semibold text-dark mb-2 text-truncate">
                                    {{ $product->nama }}
                                </h5>

                                <!-- Rating -->
                                <div class="mb-3 d-flex align-items-center">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i
                                            class="bi bi-star{{ $i < floor($product->rating) ? '-fill text-warning' : ' text-secondary' }}"></i>
                                    @endfor
                                    <small class="text-secondary ms-2">
                                        {{ $product->rating }} ({{ $product->reviews }} ulasan)
                                    </small>
                                </div>

                                <!-- Price -->
                                <div class="mb-3">
                                    <span class="h5 fw-bold text-dark me-2">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </span>
                                    @if ($product->originalPrice > $product->harga)
                                        <span class="text-muted text-decoration-line-through">
                                            Rp {{ number_format($product->originalPrice, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Button -->
                                <a href="#" class="btn btn-orange w-100 shadow-sm">
                                    <i class="bi bi-cart me-2"></i>
                                    Tambah ke Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View More Button -->
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-orange btn-lg">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    {{-- layanan --}}
    <section id="layanan" class="py-5 bg-light">
        <div class="container">
            <!-- Section Header -->
            <div class="text-center mb-5">
                <h2 class="h2 fw-bold text-dark mb-3">Layanan</h2>
                <p class="text-muted">
                    Pilih layanan terbaik kami yang disesuaikan untuk kebutuhan Anda
                </p>
            </div>

            <!-- Layanan Grid -->
            <div class="row g-4">
                <!-- Item Layanan -->
                @foreach ($layanans as $layanan)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('layanan.detail', $layanan->id) }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm h-100 text-center p-3 hover-shadow card-layanan">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                    style="width: 60px; height: 60px;">
                                    <i class="bi bi-phone fs-4"></i>
                                </div>
                                <h5 class="fw-semibold mb-2">{{ $layanan->nama_layanan }}</h5>
                                <p class="text-muted small mb-1">{{ $layanan->deskripsi }}</p>
                                <p class="text-primary small mb-1">Durasi: {{ $layanan->durasi }} menit</p>
                                <p class="fw-bold text-success mb-0">Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 bg-gradient text-white" style="background-color: #ea580c;">
        <div class="container">
            <div class="text-center">
                <!-- Badge -->
                <span class="badge bg-white text-primary fw-medium mb-4 px-4 py-2 border border-white shadow-sm"
                    style="font-size: 1rem;">
                    🎉 Penawaran Terbatas
                </span>

                <!-- Main Content -->
                <h2 class="display-5 fw-bold mb-4">
                    Bergabunglah dengan 50,000+
                    <span class="d-block">Pelanggan Bahagia Kami</span>
                </h2>

                <p class="lead mb-5 mx-auto" style="max-width: 700px;">
                    Dapatkan akses eksklusif ke produk terbaru, promo spesial, dan layanan pelanggan terbaik.
                    Daftar sekarang dan nikmati pengalaman berbelanja yang tak terlupakan!
                </p>

                <!-- CTA Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-5">
                    <a href="#" class="btn btn-lg btn-light text-orange shadow">
                        <i class="bi bi-gift me-2"></i>
                        Daftar & Dapat Bonus
                    </a>
                    <a href="#" id="btn-hubungi"
                        class="btn btn-lg btn-outline-light text-white border border-white">
                        Hubungi Customer Service
                    </a>
                </div>

                <!-- Features -->
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-4">
                        <div class="text-center">
                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width:64px;height:64px;">
                                <i class="bi bi-gift text-white fs-2"></i>
                            </div>
                            <h3 class="fw-semibold mb-2">Bonus Member Baru</h3>
                            <p class="mb-0">Voucher diskon hingga 100rb untuk pembelian pertama</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="text-center">
                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width:64px;height:64px;">
                                <i class="bi bi-clock text-white fs-2"></i>
                            </div>
                            <h3 class="fw-semibold mb-2">Pengiriman Cepat</h3>
                            <p class="mb-0">Gratis ongkir & pengiriman dalam 24 jam untuk area Jakarta</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="text-center">
                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width:64px;height:64px;">
                                <i class="bi bi-shield-check text-white fs-2"></i>
                            </div>
                            <h3 class="fw-semibold mb-2">Garansi Resmi</h3>
                            <p class="mb-0">100% original dengan garansi resmi dari brand</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Swiper(".mySwiper", {
                autoplay: {
                    delay: 2000,
                },
                loop: true,
                slidesPerView: 2, // default untuk mobile
                spaceBetween: 16,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    768: {
                        slidesPerView: 3

                    }, // tablet
                    992: {
                        slidesPerView: 5,
                        slidesPerGroup: 2,
                    }, // desktop
                },
            });
        });
    </script>
@endsection
