@extends('layouts.app')

@section('title', 'Barang - Bengkel Kasnoto Motor')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Edit Jenis Barang</h5>
                </div>
                <div class="card-body">
                <form action="{{ route('jenis-barang.update', $jenisbarang->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis Barang</label>
                        <input type="text" name="jenis" id="jenis" class="form-control" value="{{ $jenisbarang->jenis }}" required>
                    </div>
                    <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
