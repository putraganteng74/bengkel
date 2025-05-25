<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        @php
            use App\Models\Keranjang;
            use Illuminate\Support\Facades\Auth;

            $jumlahKeranjang = Auth::check()
                ? Keranjang::where('user_id', Auth::id())->sum('jumlah')
                : 0;
        @endphp
        <a class="navbar-brand" href="{{ route('index') }}">Kasnoto Motor</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Search Form (non-fungsional, perlu backend jika ingin aktif) -->
                <li class="nav-item me-3">
                    <form class="d-flex" role="search" method="GET" action="#">
                        <input class="form-control me-2" type="search" placeholder="Cari Produk" aria-label="Search" name="q">
                        <button class="btn btn-outline-light" type="submit">Cari</button>
                    </form>
                </li>

                <!-- Cart Icon -->
                <li class="nav-item me-3">
                    <a class="nav-link d-flex align-items-center position-relative" href="{{ route('keranjang.index') }}">
                        <i class="bi bi-cart3" style="font-size: 1.5rem;"></i>
                        @if ($jumlahKeranjang > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $jumlahKeranjang }}
                            </span>
                        @endif
                    </a>
                </li>

                @auth
                    <!-- Logout -->
                    <li class="nav-item me-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-light btn-sm">Keluar</button>
                        </form>
                    </li>
                @else
                    <!-- Login -->
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>

                    <!-- Register -->
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
