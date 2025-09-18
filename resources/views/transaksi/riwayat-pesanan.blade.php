@extends('layouts.app2')

@section('title', 'Riwayat Pesanan')

@section('content')
    <section class="py-5 bg-light bg-opacity-25">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="fw-bold mb-4">Riwayat Pesanan Saya</h5>
                                @if ($transaksi->isEmpty())
                                    <div class="text-center py-4">
                                        <i class="ri-shopping-cart-2-line display-4 text-muted"></i>
                                        <p class="mt-3 text-muted">Belum ada pesanan.</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kode Transaksi</th>
                                                    <th>Tanggal</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transaksi as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nomor_faktur ?? '-' }}</td>
                                                        <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                                        <td>
                                                            @if ($item->status === 'menunggu')
                                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                                            @elseif ($item->status === 'dibayar')
                                                                <span class="badge bg-success">Dibayar</span>
                                                            @endif
                                                        </td>
                                                        <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                                        <td>
                                                            <a href="{{ route('detail-transaksi', $item->id) }}"
                                                                class="btn btn-orange shadow-sm btn-sm">Detail</a>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
