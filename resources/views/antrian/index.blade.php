@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Barang</h5>
                        <a href="{{ route('barang.create') }}" class="btn btn-success">Tambah Barang</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3>Daftar Antrian</h3>
    @if ($antrians->isEmpty())
        <div class="alert alert-warning">
            Anda belum memiliki antrian. <a href="{{ route('antrian.create') }}">Buat antrian baru</a>.
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Status</th>
                    <th>Waktu Kedatangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($antrians as $antrian)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucfirst($antrian->status) }}</td>
                        <td>{{ \Carbon\Carbon::parse($antrian->waktu_datang)->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination untuk daftar antrian -->
        {{ $antrians->links() }}
    @endif
    </div>
@endsection
