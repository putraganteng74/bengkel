@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container mt-4">
    <h3>Detail Transaksi</h3>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Nomor Faktur:</strong> {{ $transaksi->nomor_faktur }}</p>
            <p><strong>Status:</strong> {{ ucfirst($transaksi->status) }}</p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
            <p><strong>Nama Pemesan:</strong> {{ $transaksi->user->username }}</p>
        </div>
    </div>

    <h5>Barang dalam Transaksi</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->detailTransaksi as $item)
                    <tr>
                        <td>{{ $item->barang->nama }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Tombol konfirmasi jika status masih menunggu --}}
    @if($transaksi->status === 'menunggu')
        <form action="{{ route('transaksi.konfirmasi', $transaksi->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
        </form>
    @endif

    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
