@extends('layouts.app2')

@section('title', 'Detail Barang')

@section('content')
<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3>{{ $layanan->nama_layanan }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Deskripsi:</strong> {{ $layanan->deskripsi }}</p>
            <p><strong>Durasi:</strong> {{ $layanan->durasi }} menit</p>
            <p><strong>Harga:</strong> Rp{{ number_format($layanan->harga, 0, ',', '.') }}</p>

        </div>

        <div class="card-footer">
            <a href="{{ route('index') }}" class="btn btn-secondary">Kembali ke Etalase</a>
        </div>
    </div>
</div>
@endsection
