@extends('layouts.app2')

@section('title', 'Keranjang Saya')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
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
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col" class="text-end">Harga</th>
                                    <th scope="col" class="text-center">Jumlah</th>
                                    <th scope="col" class="text-end">Subtotal</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($item->item->foto ?? false)
                                                    <img src="{{ asset('storage/' . $item->item->foto) }}"
                                                        alt="{{ $item->item->nama }}" class="rounded me-3"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                <span class="fw-semibold">
                                                    {{ $item->item->nama ?? $item->item->nama_layanan }}
                                                </span>
                                                <small class="text-muted ms-2">({{ ucfirst($item->item_type) }})</small>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            Rp{{ number_format($item->item->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark px-3 py-2">
                                                {{ $item->jumlah }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            Rp{{ number_format($item->item->harga * $item->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <input type="hidden" name="item_type" value="{{ $item->item_type }}">
                                                <input type="hidden" name="item_id" value="{{ $item->item_id }}">

                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"
                                                    onclick="return confirm('Hapus item ini dari keranjang?')">
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
                                        Rp{{ number_format($items->sum(fn($i) => $i->item->harga * $i->jumlah), 0, ',', '.') }}
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('checkout') }}" class="btn btn-success btn-lg shadow-sm">
                            <i class="bi bi-credit-card"></i> Lanjut ke Checkout
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection
