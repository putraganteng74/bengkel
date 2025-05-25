@extends('layouts.app2')

@section('title', 'Etalase Layanan')

@section('content')
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
