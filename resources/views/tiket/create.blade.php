@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Buat Antrian</h3>

    <form action="{{ route('antrian.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="layanan_id" class="form-label">Layanan</label>
            <select name="layanan_id" id="layanan_id" class="form-control" required>
                @foreach($layanans as $layanan)
                    <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Buat Antrian</button>
    </form>
</div>
@endsection
