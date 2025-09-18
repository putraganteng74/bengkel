@extends('layouts.app')

@section('title', 'Buat Transaksi - Bengkel Kasnoto Motor')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Buat Transaksi Baru</h5>
                        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-3">
                            <form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi">
                                @csrf
                                <table class="table table-bordered" id="tabel-barang">
                                    <thead>
                                        <tr>
                                            <th>Barang</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    onclick="tambahBarang()">+</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="item_id[]" class="form-select barang-select"
                                                    onchange="updateHarga(this)" required>
                                                    <option value="">-- Pilih Barang / Layanan --</option>

                                                    <optgroup label="Barang">
                                                        @foreach ($barang as $item)
                                                            <option value="barang-{{ $item->id }}"
                                                                data-harga="{{ $item->harga }}">
                                                                {{ $item->nama }} (Stok: {{ $item->stok }})
                                                            </option>
                                                        @endforeach
                                                    </optgroup>

                                                    <optgroup label="Layanan">
                                                        @foreach ($layanan as $item)
                                                            <option value="jasa-{{ $item->id }}"
                                                                data-harga="{{ $item->harga }}">
                                                                {{ $item->nama_layanan }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>

                                            </td>
                                            <td><input type="text" name="harga[]" onchange=""
                                                    class="form-control harga" readonly></td>
                                            <td><input type="number" name="jumlah[]" class="form-control jumlah"
                                                    min="1" value="1" onchange="updateSubtotal(this)" required>
                                            </td>
                                            <td><input type="text" name="subtotal[]" class="form-control subtotal"
                                                    readonly></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="hapusBaris(this)">×</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="mb-3 text-end">
                                    <label for="total" class="form-label fw-bold">Total Harga:</label>
                                    <input type="text" id="total_display" class="form-control d-inline-block w-auto"
                                        readonly>
                                    <input type="hidden" id="total" name="total">
                                </div>


                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
