@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tiket Antrian</h3>

    <div class="alert alert-info">
        <strong>Tiket Antrian Anda</strong><br>
        Status: {{ ucfirst($antrian->status) }}<br>
        Waktu Datang: {{ $antrian->waktu_datang }}
    </div>
</div>
@endsection
