<div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('barang.index') }}">
                    Daftar Barang
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('layanans.index') }}">
                    Layanan
                </a>
            </li>
            @auth
            <li class="nav-item">
                @if($hasOrder)
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
</div>
