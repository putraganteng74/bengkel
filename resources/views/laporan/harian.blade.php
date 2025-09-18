@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Laporan Harian'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Laporan Harian Barang ({{ $today->format('d M Y') }})</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-2">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Barang
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                        Barang</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga
                                        Satuan
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporanBarang as $index => $barang)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $barang->id ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $barang->nama ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $barang->total_terjual ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                Rp {{ number_format($barang->total_pendapatan, 0, ',', '.') }}
                                            </p>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada transaksi hari ini</td>
                                    </tr>
                                @endforelse
                                @if ($laporanBarang->count() > 0)
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">Total</td>
                                        <td>
                                            Rp {{ number_format($laporanBarang->sum('total_pendapatan'), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Laporan Harian Layanan ({{ $today->format('d M Y') }})</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-2">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID
                                        Layanan
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                        Layanan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporanLayanan as $index => $layanan)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $layanan->id ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $layanan->nama_layanan ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                Rp {{ number_format($layanan->harga, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $layanan->total_terjual ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                Rp {{ number_format($layanan->total_pendapatan, 0, ',', '.') }}
                                            </p>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada transaksi hari ini</td>
                                    </tr>
                                @endforelse
                                @if ($laporanLayanan->count() > 0)
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">Total</td>
                                        <td>
                                            Rp {{ number_format($laporanLayanan->sum('total_pendapatan'), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('layouts.footers.auth.footer')     --}}
@endsection
