@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="container mt-3">
        {{-- Info Transaksi --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Nomor Faktur</p>
                        <h6 class="fw-semibold">{{ $transaksi->nomor_faktur }}</h6>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Status</p>
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
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Nama Pemesan</p>
                        <h6 class="fw-semibold">{{ $transaksi->user->username }}</h6>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Dibayar</p>
                        <h5 class="fw-bold text-success">
                            Rp {{ number_format($transaksi->dibayar, 0, ',', '.') }}
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Total Harga</p>
                        <h5 class="fw-bold text-success">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Kembalian</p>
                        <h5 class="fw-bold text-primary">
                            Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Barang dalam Transaksi --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">
                    <i class="ri-shopping-cart-2-line text-primary me-1"></i> Barang dalam Transaksi
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi->detailTransaksi as $item)
                                <tr>
                                    <td>{{ $item->item->nama ?? $item->item->nama_layanan }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="fw-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Konfirmasi Pembayaran --}}
                @if ($transaksi->status === 'menunggu')
                    <form action="{{ route('transaksi.konfirmasi', $transaksi->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="dibayar" class="form-label fw-semibold">Jumlah Dibayar (Rp)</label>
                            <input type="number" name="dibayar" id="dibayar" class="form-control" required
                                placeholder="Contoh: 100000">
                        </div>

                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="ri-check-line me-1"></i> Konfirmasi Pembayaran
                        </button>
                    </form>
                @endif

                {{-- Tombol Kembali --}}
                <a href="{{ route('transaksi.index') }}" class="btn btn-primary text-end">
                    <i class="ri-arrow-left-line me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
