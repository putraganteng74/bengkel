@extends('layouts.app')

@section('title', 'Layanan - Bengkel Kasnoto Motor')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Layanan</h5>
                    <a href="{{ route('layanans.create') }}" class="btn btn-success">Tambah layanan</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center mb-0">
                            <div class="d-flex justify-content-center">
                                {{ $layanans->links() }}
                            </div>
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Nama Layanan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Deskripsi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Durasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($layanans as $key => $layanan)
                                <tr>
                                    <td class="text-xs font-weight-bold">{{ $key + 1 }}</td>
                                    <td class="text-xs font-weight-bold">{{ $layanan->nama_layanan }}</td>
                                    <td class="text-xs font-weight-bold">{{ $layanan->deskripsi }}</td>
                                    <td class="text-xs font-weight-bold">{{ $layanan->durasi }} menit</td>
                                    <td class="text-xs font-weight-bold">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('layanans.edit', $layanan->id) }}" class="btn btn-info btn-sm">Edit</a>
                                        <form action="{{ route('layanans.destroy', $layanan->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $layanan->nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
