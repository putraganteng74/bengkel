@extends('layouts.app2')

@section('title', 'Etalase Barang')

@section('content')
    <section class="pt-5 py-5 bg-light bg-opacity-25">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h2 fw-bold text-dark mb-3">Produk</h2>
                <p class="text-muted">
                    Pilih produk terbaik untuk kebutuhan Anda
                </p>
            </div>
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
                                {{-- <button type="button"
                                    class="btn btn-light btn-sm position-absolute top-0 end-0 m-3 rounded-circle shadow-sm fav-btn">
                                    <i class="bi bi-heart"></i>
                                </button> --}}
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
                                {{-- <div class="mb-3 d-flex align-items-center">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i
                                            class="bi bi-star{{ $i < floor($product->rating) ? '-fill text-warning' : ' text-secondary' }}"></i>
                                    @endfor
                                    <small class="text-secondary ms-2">
                                        {{ $product->rating }} ({{ $product->reviews }} ulasan)
                                    </small>
                                </div> --}}

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

                                <form action="{{ route('keranjang.tambah') }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $product->id }}">
                                    <input type="hidden" name="item_type" value="barang">
                                    <input type="hidden" name="jumlah" value="1">

                                    <!-- Tombol -->
                                    <button type="submit" class="btn btn-orange w-100 shadow-sm">
                                        <i class="bi bi-cart me-2"></i> Tambah ke Keranjang
                                    </button>

                                    <a href="{{ route('etalase.detail', $product->id) }}"
                                        class="btn btn-primary w-100 shadow-sm mt-2">
                                        <i class="bi bi-info-circle me-2"></i> Lihat Detail
                                    </a>
                                </form>


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
