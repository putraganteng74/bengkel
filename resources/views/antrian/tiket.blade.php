@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Tiket Aktif --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            @if($tiketAktif)
                <div class="card text-center shadow-lg border border-dark">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">TIKET ANTRIAN AKTIF</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="display-4">{{ $tiketAktif->kode_tiket }}</h1>
                        <hr>
                        <p class="mb-1"><strong>Nama Anda</strong></p>
                        <h5>{{ $tiketAktif->user->username }}</h5>
                        <p class="mb-1 mt-3"><strong>Jadwal Kunjungan:</strong></p>
                        <h5>{{ \Carbon\Carbon::parse($tiketAktif->jadwal_kunjungan)->translatedFormat('l, d M Y • H:i') }}</h5>
                        <p class="mt-4">
                            <span class="badge bg-warning text-dark" style="font-size: 1rem;">{{ strtoupper($tiketAktif->status) }}</span>
                        </p>
                    </div>
                    <div class="card-footer text-muted">
                        Tunjukkan tiket ini saat datang ke bengkel
                    </div>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    Anda belum memiliki tiket antrian aktif. <a href="{{ route('antrian.create') }}">Buat antrian sekarang</a>.
                </div>
            @endif
        </div>
    </div>

    {{-- Riwayat Semua Antrian --}}
    <div class="row">
        <div class="col-12">
            <h4>Riwayat Antrian Saya</h4>
            @if($semuaAntrian->isEmpty())
                <div class="alert alert-info">
                    Belum ada riwayat antrian.
                </div>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($semuaAntrian as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($semuaAntrian->currentPage() - 1) * $semuaAntrian->perPage() }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->waktu_datang)->format('d-m-Y H:i') }}</td>
                                <td><span class="badge bg-{{ $item->status == 'menunggu' ? 'warning' : ($item->status == 'selesai' ? 'success' : 'secondary') }}">{{ ucfirst($item->status) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $semuaAntrian->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
