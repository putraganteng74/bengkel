@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <style>
        .queue-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .queue-item {
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status {
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 9999px;
        }

        .status.waiting {
            background-color: #fbbf24;
            color: #92400e;
        }

        .status.serving {
            background-color: #3b82f6;
            color: white;
        }

        .status.missed {
            background-color: #ef4444;
            color: white;
        }

        .status.done {
            background-color: #10b981;
            color: white;
        }

        .card-queue {
            overflow: hidden;
        }

        .button-queue:disabled {
            background-color: #a5b4fc;
            cursor: not-allowed;
        }
    </style>


    <div class="container-fluid py-4">
        <div class="row">
            <!-- Rekap Harian -->
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <a href="{{ route('laporan-harian') }}" class="text-decoration-none">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Harian</p>
                                        <h5 class="font-weight-bolder">Rp{{ number_format($totalHarian, 0, ',', '.') }}</h5>
                                        <p class="mb-0">
                                            <span
                                                class="{{ $persenHarian['naik'] ? 'text-success' : 'text-danger' }} text-sm font-weight-bolder">
                                                {{ $persenHarian['naik'] ? '+' : '-' }}{{ $persenHarian['nilai'] }}%
                                            </span>
                                            dibanding kemarin
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="ni ni-chart-bar-32 text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Transaksi Bulanan -->
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <a href="{{ route('laporan-bulanan') }}" class="text-decoration-none">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Bulanan</p>
                                        <h5 class="font-weight-bolder">{{ number_format($totalBulanan) }}</h5>
                                        <p class="mb-0">
                                            <span
                                                class="{{ $persenBulanan['naik'] ? 'text-success' : 'text-danger' }} text-sm font-weight-bolder">
                                                {{ $persenBulanan['naik'] ? '+' : '-' }}{{ $persenBulanan['nilai'] }}%
                                            </span>
                                            dibanding minggu lalu
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Pengunjung Website -->
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <a href="{{ route('laporan-customer') }}" class="text-decoration-none">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Customer</p>
                                        <h5 class="font-weight-bolder">{{ number_format($totalAkun) }}</h5>
                                        <p class="mb-0">
                                            <span
                                                class="{{ $persenTotalAkun['naik'] ? 'text-success' : 'text-danger' }} text-sm font-weight-bolder">
                                                {{ $persenTotalAkun['naik'] ? '+' : '-' }}{{ $persenTotalAkun['nilai'] }}%
                                            </span>
                                            dibanding bulan lalu
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Akun Baru -->
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <a href="{{ route('laporan-akunbaru') }}" class="text-decoration-none">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Akun Baru</p>
                                        <h5 class="font-weight-bolder">{{ number_format($akunBaruBulanIni) }}</h5>
                                        <p class="mb-0">
                                            <span
                                                class="{{ $persenAkunBaru['naik'] ? 'text-success' : 'text-danger' }} text-sm font-weight-bolder">
                                                {{ $persenAkunBaru['naik'] ? '+' : '-' }}{{ $persenAkunBaru['nilai'] }}%
                                            </span>
                                            dibanding bulan lalu
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="ni ni-circle-08 text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Sales overview</h6>
                        <p class="text-sm mb-0">
                            <i
                                class="fa {{ $salesChange['naik'] ? 'fa-arrow-up text-success' : 'fa-arrow-down text-danger' }}"></i>
                            <span class="font-weight-bold">
                                {{ $salesChange['value'] }}% {{ $salesChange['naik'] ? 'lebih banyak' : 'lebih sedikit' }}
                            </span>
                            dibanding bulan lalu.
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card h-100 card-queue">
                    <div class="card-header pb-0 p-3 text-center">
                        <h6 class="mb-2">Daftar Antrian</h6>
                        <p class="text-muted small">Kelola antrian dan konfirmasi kehadiran</p>
                    </div>
                    <div class="queue-list">
                        @forelse ($queues as $index => $queue)
                            <div class="queue-item">
                                <div class="">
                                    <h6 class="text-sm mb-0">{{ $queue->user->firstname }}
                                        {{ $queue->user->lastname }}
                                        <small class="text-muted">#{{ $index + 1 }}</small>
                                    </h6>
                                    <p class="text-xs font-weight-bold mb-0">
                                        {{ \Carbon\Carbon::parse($queue->waktu_datang)->format('d M Y') }}
                                        pukul {{ \Carbon\Carbon::parse($queue->waktu_datang)->format('H:i') }}
                                    </p>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    @php
                                        $statusMap = [
                                            'menunggu' => ['class' => 'waiting', 'text' => 'Menunggu'],
                                            'diproses' => ['class' => 'serving', 'text' => 'Diproses'],
                                            'dibatalkan' => ['class' => 'missed', 'text' => 'Dibatalkan'],
                                            'selesai' => ['class' => 'done', 'text' => 'Selesai'],
                                        ];
                                        $status = $statusMap[$queue->status] ?? [
                                            'class' => '',
                                            'text' => $queue->status,
                                        ];
                                    @endphp

                                    <span class="status {{ $status['class'] }} text-xs">{{ $status['text'] }}</span>

                                    @if ($queue->status === 'diproses')
                                        <div class="btn-group btn-group-sm" role="group">
                                            <form method="POST"
                                                action="{{ route('queues.updateStatus', ['queue' => $queue->id]) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit" class="btn btn-success mb-0">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                            <form method="POST"
                                                action="{{ route('queues.updateStatus', ['queue' => $queue->id]) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="dibatalkan">
                                                <button type="submit" class="btn btn-danger mb-0">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center mb-0 p-3">Tidak ada antrian saat ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');

        const labels = {!! json_encode(collect($monthlySales)->pluck('label')) !!};
        const data = {!! json_encode(collect($monthlySales)->pluck('total')) !!};

        new Chart(ctx1, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "Penjualan",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: data,
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
@endpush
