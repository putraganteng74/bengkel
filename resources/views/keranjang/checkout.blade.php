@extends('layouts.app2')

@section('title', 'Checkout')

@section('content')
<div class="container mt-4">
    <h2>Checkout</h2>

    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->barang->nama }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp{{ number_format($item->barang->harga, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->barang->harga * $item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th>Rp{{ number_format($total, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Tombol Konfirmasi --}}
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        @if (!empty($isDirectBuy) && $isDirectBuy)
            <input type="hidden" name="direct_buy" value="1">
            <input type="hidden" name="barang_id" value="{{ $items->first()->barang->id }}">
            <input type="hidden" name="jumlah" value="{{ $items->first()->jumlah }}">
        @endif
        
        <button type="submit" class="btn btn-success">Konfirmasi dan Bayar</button>
        <a href="{{ route('keranjang.index') }}" class="btn btn-secondary">Kembali ke Keranjang</a>
    </form>
</div>
@endsection
