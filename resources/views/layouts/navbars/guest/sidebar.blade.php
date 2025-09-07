@auth
    <button class="btn btn-trigger shadow-lg" type="button"
        style="background-color: var(--primary); left: 20px; top: 50%; transform: translateY(-50%);"
        data-bs-toggle="offcanvas" data-bs-target="#queueOffcanvas">
        <i class="bi bi-ticket-perforated fs-5"></i>
        <span
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge pulse">
            {{ $totalAntrian }}<span class="visually-hidden">tiket menunggu</span>
        </span>
    </button>

    <!-- Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="queueOffcanvas" aria-labelledby="queueOffcanvasLabel"
        style="padding: 0px;">
        <div class="offcanvas-header text-white" style="background-color: var(--primary);">
            <h5 class="offcanvas-title" id="queueOffcanvasLabel">Tiket Antrian</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="d-flex flex-column h-100">
                <div class="px-3 py-2 border-bottom">
                    <div class="text-muted small">Anda memiliki <strong>{{ $totalAntrian }}</strong> tiket antrian</div>
                </div>

                <div class="flex-grow-1 overflow-auto py-2">
                    @forelse ($antrians as $antrian)
                        @php
                            $statusClasses = [
                                'menunggu' => 'ticket-waiting',
                                'diproses' => 'ticket-process',
                                'selesai' => 'ticket-completed',
                                'dibatalkan' => 'ticket-missed',
                            ];
                            $statusClass = $statusClasses[strtolower($antrian->status)] ?? 'ticket-default';
                        @endphp

                        <div class="ticket-card {{ $statusClass }} m-3 p-3 bg-white rounded shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div
                                        class="small fw-bold mb-1
                                        @if (strtolower($antrian->status) === 'menunggu') text-primary
                                        @elseif(strtolower($antrian->status) === 'diproses') text-warning
                                        @elseif(strtolower($antrian->status) === 'selesai') text-success
                                        @elseif(strtolower($antrian->status) === 'dibatalkan') text-danger
                                        @else bg-secondary bg-opacity-10 text-secondary @endif
                                    ">
                                        {{ $antrian->id }}
                                    </div>
                                    <h6 class="mb-1">
                                        {{ \Carbon\Carbon::parse($antrian->waktu_datang)->format('d M Y H:i') }}</h6>
                                    <small class="text-muted">Dibuat: {{ $antrian->created_at->diffForHumans() }}</small>
                                </div>
                                <span
                                    class="badge
                                    @if (strtolower($antrian->status) === 'menunggu') bg-primary bg-opacity-10 text-primary
                                    @elseif(strtolower($antrian->status) === 'diproses') bg-warning bg-opacity-10 text-warning
                                    @elseif(strtolower($antrian->status) === 'selesai') bg-success bg-opacity-10 text-success
                                    @elseif(strtolower($antrian->status) === 'dibatalkan') bg-danger bg-opacity-10 text-danger
                                    @else bg-secondary bg-opacity-10 text-secondary @endif
                            ">
                                    {{ ucfirst($antrian->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted my-5">
                            <i class="bi bi-ticket-perforated fs-1"></i>
                            <p class="mt-3">Tidak ada tiket antrian.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Footer with action button -->
                <div class="border-top p-3">
                    <button type="button" class="btn w-100" style="background-color: var(--primary); color: white"
                        data-bs-toggle="modal" data-bs-target="#ticketModal">
                        <i class="bi bi-plus-lg me-2"></i> Buat Tiket Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('antrian.store') }}" method="POST" class="modal-content">
                @csrf

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Tiket Antrian</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    {{-- Tampilkan error jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Input untuk waktu kedatangan --}}
                    <div class="mb-3">
                        <label for="waktu_datang" class="form-label">Waktu Kedatangan</label>
                        <input type="datetime-local" class="form-control @error('waktu_datang') is-invalid @enderror"
                            id="waktu_datang" name="waktu_datang" value="{{ old('waktu_datang') }}" required>
                        @error('waktu_datang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Buat Antrian</button>
                </div>
            </form>
        </div>
    </div>

@endauth
