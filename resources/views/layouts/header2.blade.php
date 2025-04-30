<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Kasnoto Motor</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Search Form -->
                <li class="nav-item">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Cari Produk" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Cari</button>
                    </form>
                </li>

                <!-- Cart Icon -->
                <li class="nav-item ms-3">
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="bi bi-cart3" style="font-size: 1.5rem;"></i>
                    </a>
                </li>

                <!-- Login -->
                <li class="nav-item ms-3">
                    <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">Masuk</a>
                </li>

                <!-- Register -->
                <li class="nav-item ms-3">
                    <a class="nav-link d-flex align-items-center" href="{{ route('register') }}">Daftar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Link to Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
