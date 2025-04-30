@extends('layouts.app2')

@section('title', 'Etalase Barang')

@section('content')
<div class="row">
    @foreach ($barang as $item)
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top" alt="{{ $item->nama }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->nama }}</h5>
                    <p class="card-text">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    <a href="{{ route('etalase.detail', $item->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
