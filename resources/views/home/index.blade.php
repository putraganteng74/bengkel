@extends('layouts.app2')

@section('title', 'Etalase Barang')

@section('content')
<h3>Barang</h3>
<div class="row">
    @foreach ($barangs as $barang)
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="{{ asset('storage/' . $barang->foto) }}" class="card-img-top" alt="{{ $barang->nama }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $barang->nama }}</h5>
                    <p class="card-text">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                    <a href="{{ route('etalase.detail', $barang->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<h3>Layanan</h3>
<div class="row">
    @foreach ($layanans as $layanan)
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $layanan->nama_layanan }}</h5>
                    <p class="card-text">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</p>
                    <a href="{{ route('layanan.detail', $layanan->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
