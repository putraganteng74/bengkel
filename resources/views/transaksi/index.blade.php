@extends('layouts.app')

@section('title', 'Transaksi - Bengkel Kasnoto Motor')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Transaksi</h5>
                    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Nomor Faktur</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Pelanggan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Total Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $key => $item)
                                <tr>
                                    <td class="text-xs">{{ $key + 1 }}</td>
                                    <td class="text-xs">{{ $item->nomor_faktur }}</td>
                                    <td class="text-xs">{{ $item->user->username ?? 'Tidak Diketahui' }}</td>
                                    <td class="text-xs">Rp{{ number_format($item->total_harga ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-xs">
                                        @if ($item->status === 'menunggu')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @else
                                            <span class="badge bg-success">Dibayar</span>
                                        @endif
                                    </td>
                                    <td class="text-xs">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('transaksi.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        {{-- @if ($item->status === 'menunggu')
                                        <form action="{{ route('transaksi.konfirmasi', $item->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Konfirmasi pembayaran transaksi ini?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                                        </form>
                                        @endif --}}
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalKonfirmasi-{{ $item->id }}">
                                            Konfirmasi
                                        </button>
                                    </td>
                                </tr>
                                <!-- Modal: Pindahkan ke dalam loop -->
<div class="modal fade" id="modalKonfirmasi-{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('transaksi.konfirmasi', $item->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel-{{ $item->id }}">Konfirmasi Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="dibayar-{{ $item->id }}" class="form-label">Jumlah Dibayar (Rp)</label>
            <input type="text" name="dibayar" id="dibayar-{{ $item->id }}" class="form-control" required>
          </div>
          <p>Apakah Anda yakin ingin mengonfirmasi pembayaran transaksi ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Konfirmasi</button>
        </div>
      </div>
    </form>
  </div>
</div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $transaksi->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
