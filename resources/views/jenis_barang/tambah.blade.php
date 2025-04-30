@extends('layouts.app')

@section('title', 'Input Barang - Bengkel Kasnoto Motor')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Input Jenis Barang Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenis-barang.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="jenis_barang" class="form-label">Jenis Barang</label>
                            <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" required>
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
