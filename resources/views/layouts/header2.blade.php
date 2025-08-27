<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        @php
            use App\Models\Keranjang;
            use Illuminate\Support\Facades\Auth;

            $jumlahKeranjang = Auth::check() ? Keranjang::where('user_id', Auth::id())->sum('jumlah') : 0;
        @endphp

        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('index') }}">Kasnoto Motor</a>

        <!-- Toggle Button Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu & Search -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('produk') ? 'active' : '' }}"
                        href="{{ route('produk') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('layanan') ? 'active' : '' }}"
                        href="{{ route('layanan') }}">Layanan</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">Tentang Kami</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kontak') ? 'active' : '' }}"
                        href="{{ route('kontak') }}">Kontak</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input class="form-control search-input" type="search" placeholder="Cari sparepart..."
                        aria-label="Search">
                </div>
                <button class="btn btn-search d-none d-lg-inline-block ms-2" type="button">Cari</button>
            </div>

            <ul class="navbar-nav">
                <li class="nav-item ms-lg-2">
                    <a class="nav-link" href="{{ route('keranjang.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge bg-primary rounded-pill ms-1">{{ $jumlahKeranjang }}</span>
                    </a>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown me-2">
                    <a class="nav-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        @auth
                            <li>
                                <a class="dropdown-item" href="#">Akun</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Keluar</button>
                                </form>
                            </li>
                        @else
                            <li>
                                <a class="dropdown-item" href="{{ route('login') }}">Masuk</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('register') }}">Daftar</a>
                            </li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
