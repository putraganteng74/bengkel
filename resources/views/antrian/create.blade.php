@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Buat Antrian Baru</h5>
                </div>
                <div class="card-body px-4 pt-3 pb-2">
                    <!-- Menampilkan pesan jika ada error -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form untuk membuat antrian -->
                    <form action="{{ route('antrian.store') }}" method="POST">
                        @csrf
                        <!-- Input untuk memilih waktu datang -->
                        <div class="mb-3">
                            <label for="waktu_datang" class="form-label">Waktu Kedatangan</label>
                            <input type="datetime-local" class="form-control" id="waktu_datang" name="waktu_datang" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Buat Antrian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
