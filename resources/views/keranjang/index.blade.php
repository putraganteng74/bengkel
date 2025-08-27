@extends('layouts.app2')

@section('title', 'Keranjang Saya')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="fw-bold mb-4">🛒 Keranjang Belanja</h3>

                @if ($items->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x display-4 text-muted"></i>
                        <p class="mt-3 text-muted">Keranjang Anda kosong.</p>
                        <a href="{{ route('produk') }}" class="btn btn-primary">
                            <i class="bi bi-shop"></i> Belanja Sekarang
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $item->barang->foto) }}"
                                                    alt="{{ $item->barang->nama }}" class="rounded me-3"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                <span class="fw-semibold">{{ $item->barang->nama }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end">Rp{{ number_format($item->barang->harga, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->jumlah }}</td>
                                        <td class="text-end">
                                            Rp{{ number_format($item->barang->harga * $item->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th class="text-end">
                                        Rp{{ number_format($items->sum(fn($i) => $i->barang->harga * $i->jumlah), 0, ',', '.') }}
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('checkout') }}" class="btn btn-lg btn-success shadow-sm">
                            <i class="bi bi-credit-card"></i> Lanjut ke Checkout
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
