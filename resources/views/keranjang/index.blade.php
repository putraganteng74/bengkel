@extends('layouts.app2')

@section('title', 'Keranjang Saya')

@section('content')
<div class="container mt-4">
    <h3>Keranjang Belanja Anda</h3>

    @if ($items->isEmpty())
        <p>Keranjang Anda kosong.</p>
    @else
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->barang->nama }}</td>
                        <td>Rp{{ number_format($item->barang->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp{{ number_format($item->barang->harga * $item->jumlah, 0, ',', '.') }}</td>
                        <td>
                            {{-- Hapus item dari keranjang (optional) --}}
                            <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Tombol ke Checkout --}}
        <a href="{{ route('checkout') }}" class="btn btn-success">Lanjut ke Checkout</a>
    @endif
</div>
@endsection
