@extends('layouts.app2')

@section('title', 'Detail Transaksi')

@section('content')
    <section class="py-5 bg-light bg-opacity-25">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="fw-bold mb-4">
                                Detail Transaksi
                            </h3>

                            {{-- Info Transaksi --}}
                            <div class="row mb-4">
                                <div class="col-md-6 mb-2">
                                    <p class="mb-1 text-muted">Kode Transaksi</p>
                                    <h6 class="fw-semibold">{{ $transaksi->nomor_faktur ?? '-' }}</h6>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-1 text-muted">Tanggal</p>
                                    <h6 class="fw-semibold">{{ $transaksi->created_at->format('d M Y H:i') }}</h6>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-1 text-muted">Status</p>
                                    @if ($transaksi->status === 'menunggu')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                            <i class="ri-time-line me-1"></i> Menunggu
                                        </span>
                                    @elseif ($transaksi->status === 'dibayar')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">
                                            <i class="ri-check-double-line me-1"></i> Dibayar
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                            {{ ucfirst($transaksi->status) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-1 text-muted">Total</p>
                                    <h5 class="fw-bold text-success">Rp
                                        {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h5>
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- Detail Barang --}}
                            <h5 class="fw-bold mb-3">
                                <i class="ri-shopping-cart-2-line me-2 text-primary"></i> Daftar Barang
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Harga Satuan</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksi->detailTransaksi as $detail)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $detail->item->nama ?? $detail->item->nama_layanan }}</td>
                                                <td>{{ $detail->jumlah }}</td>
                                                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                                <td class="fw-semibold text-dark">
                                                    Rp {{ number_format($detail->jumlah * $detail->harga, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Tombol Kembali --}}
                            <div class="mt-4">
                                <a href="{{ route('riwayat-pesanan') }}" class="btn btn-orange w-100 shadow-sm">
                                    <i class="ri-arrow-left-line me-1"></i> Kembali ke Riwayat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
