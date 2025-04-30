@extends('layouts.app')

@section('title', 'Barang - Bengkel Kasnoto Motor')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Jenis Barang</h5>
                    <a href="{{ route('jenis-barang.create') }}" class="btn btn-success">Tambah Jenis Barang</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Jenis Barang</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenisbarang as $key => $item)
                                <tr>
                                    <td class="text-xs font-weight-bold">{{ $key + 1 }}</td>
                                    <td class="text-xs font-weight-bold">{{ $item->jenis }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('jenis-barang.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('jenis-barang.destroy', $item->id) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $item->jenis }}?')">
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