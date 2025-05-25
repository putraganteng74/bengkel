@extends('layouts.app')

@section('title', 'Barang - Bengkel Kasnoto Motor')

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
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-0">
                                <div class="d-flex justify-content-center">
                                    {{ $barang->links() }}
                                </div>
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">foto</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Nama Barang
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Harga</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Stok</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang as $key => $item)
                                        <tr>
                                            <td class="text-xs font-weight-bold">{{ $key + 1 }}</td>
                                            <td class="text-xs font-weight-bold">
                                                @if ($item->foto)
                                                    <img src="{{ asset('storage/' . $item->foto) }}"
                                                        alt="{{ $item->nama }}" width="80" class="rounded">
                                                @else
                                                    <span class="text-muted">Tidak ada foto</span>
                                                @endif
                                            </td>
                                            <td class="text-xs font-weight-bold">{{ $item->nama }}</td>
                                            <td class="text-xs font-weight-bold">Rp
                                                {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td class="text-xs font-weight-bold">{{ $item->stok }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('barang.show', $item->id) }}"
                                                    class="btn btn-info btn-sm">Detail</a>
                                                <a href="{{ route('barang.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('barang.destroy', $item->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $item->nama }}?')">
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
