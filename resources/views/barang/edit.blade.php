@extends('layouts.app')

@section('title', 'Barang - Bengkel Kasnoto Motor')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Barang</h5>
                </div>
                <div class="card-body">
                <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $barang->nama }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto (kosongkan jika tidak ingin mengganti)</label><br>
                            @if ($barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}" width="100" class="mb-2 rounded">
                            @endif
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $barang->deskripsi }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="id_jenis_barang" class="form-label">Jenis Barang</label>
                            <select class="form-control" id="id_jenis_barang" name="id_jenis_barang" required>
                                <option value="">Pilih Jenis</option>
                                @foreach ($jenis as $item)
                                    <!-- <option value="{{ $item->id_jenis_barang }}" {{ $barang->jenis_barang == $item->id_jenis_barang ? 'selected' : '' }}>
                                        {{ $item->jenis }}
                                    </option> -->
                                    <option value="{{ $item->id }}" {{ $barang->id_jenis_barang == $item->id ? 'selected' : '' }}>
                                        {{ $item->jenis }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ $barang->harga }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" value="{{ $barang->stok }}" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
