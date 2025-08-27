@auth
    <button class="btn btn-trigger shadow-lg" type="button"
        style="background-color: var(--primary); left: 20px; top: 50%; transform: translateY(-50%);"
        data-bs-toggle="offcanvas" data-bs-target="#queueOffcanvas">
        <i class="bi bi-ticket-perforated fs-5"></i>
        <span
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge pulse">
            3<span class="visually-hidden">tiket menunggu</span>
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
                    <div class="text-muted small">Anda memiliki <strong>3</strong> tiket antrian</div>
                </div>

                <div class="flex-grow-1 overflow-auto py-2">
                    <!-- Ticket Item 1 -->
                    <div class="ticket-card ticket-waiting m-3 p-3 bg-white rounded shadow-sm">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-primary small fw-bold mb-1">ANT-2023-001</div>
                                <h6 class="mb-1">Registrasi Pengguna Baru</h6>
                                <small class="text-muted">Dibuat: 10 menit lalu</small>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary">Menunggu</span>
                        </div>
                    </div>

                    <!-- Ticket Item 2 -->
                    <div class="ticket-card ticket-process m-3 p-3 bg-white rounded shadow-sm">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-warning small fw-bold mb-1">ANT-2023-002</div>
                                <h6 class="mb-1">Pertanyaan Produk</h6>
                                <small class="text-muted">Dibuat: 35 menit lalu</small>
                            </div>
                            <span class="badge bg-warning bg-opacity-10 text-warning">Diproses</span>
                        </div>
                    </div>

                    <!-- Ticket Item 3 -->
                    <div class="ticket-card ticket-completed m-3 p-3 bg-white rounded shadow-sm">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-success small fw-bold mb-1">ANT-2023-003</div>
                                <h6 class="mb-1">Permintaan Dukungan Teknis</h6>
                                <small class="text-muted">Dibuat: 1 jam lalu</small>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success">Selesai</span>
                        </div>
                    </div>
                </div>

                <!-- Footer with action button -->
                <div class="border-top p-3">
                    <button class="btn w-100" style="background-color: var(--primary); color: white">
                        <i class="bi bi-plus-lg me-2"></i> Buat Tiket Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
@endauth

<!-- Tombol trigger offcanvas -->
{{-- <button class="btn btn-outline-secondary btn-sm z-3" type="button" data-bs-toggle="offcanvas"
data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"
style="position: fixed; left: 16px; top: 50%; transform: translateY(-50%); border-radius: 50%; width: 32px; height: 32px; padding: 0;">
<span style="font-size: 1.2rem;">Tiket Antrian</span>
</button> --}}

<!-- Offcanvas Sidebar -->
{{-- <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            @auth
            <li class="nav-item">
                @if ($hasOrder)
                <a class="nav-link text-success fw-bold" href="{{ route('antrian.tiket') }}">
                            🎟️ Tiket Antrian
                        </a>
                    @else
                        <a class="nav-link text-muted disabled" href="javascript:void(0)" onclick="return false;">
                            🎟️ Tiket Antrian
                        </a>
                    @endif
                </li>
            @endauth
        </ul>
    </div>
</div> --}}
