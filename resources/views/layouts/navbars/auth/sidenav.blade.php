<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}">
            <img src="/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Bengkel Kasnoto Motor</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                    <i class="ni ni-tv-2 text-primary"></i>
                    <span class="nav-link-text ms-2">Dashboard</span>
                </a>
            </li>

            <!-- Laravel Examples -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Laravel Examples</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
                    <i class="ni ni-single-02 text-dark"></i>
                    <span class="nav-link-text ms-2">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('user-management*') ? 'active' : '' }}" href="{{ route('page', ['page' => 'user-management']) }}">
                    <i class="ni ni-bullet-list-67 text-dark"></i>
                    <span class="nav-link-text ms-2">User Management</span>
                </a>
            </li>

            <!-- Pages -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('barang*') ? 'active' : '' }}" href="{{ route('barang.index') }}">
                    <i class="ni ni-box-2 text-warning"></i>
                    <span class="nav-link-text ms-2">Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('jenis-barang*') ? 'active' : '' }}" href="{{ route('jenis-barang.index') }}">
                    <i class="ni ni-box-2 text-warning"></i>
                    <span class="nav-link-text ms-2">Jenis Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('transaksi*') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                    <i class="ni ni-money-coins text-success"></i>
                    <span class="nav-link-text ms-2">Transaksi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('tables*') ? 'active' : '' }}" href="{{ route('page', ['page' => 'tables']) }}">
                    <i class="ni ni-calendar-grid-58 text-warning"></i>
                    <span class="nav-link-text ms-2">Tables</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('billing*') ? 'active' : '' }}" href="{{ route('page', ['page' => 'billing']) }}">
                    <i class="ni ni-credit-card text-success"></i>
                    <span class="nav-link-text ms-2">Billing</span>
                </a>
            </li>

            <!-- Account Pages -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account Pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile-static' ? 'active' : '' }}" href="{{ route('profile-static') }}">
                    <i class="ni ni-single-02 text-dark"></i>
                    <span class="nav-link-text ms-2">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sign-in-static') }}">
                    <i class="ni ni-single-copy-04 text-warning"></i>
                    <span class="nav-link-text ms-2">Sign In</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sign-up-static') }}">
                    <i class="ni ni-collection text-info"></i>
                    <span class="nav-link-text ms-2">Sign Up</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="sidenav-footer mx-3">
        <div class="card card-plain shadow-none" id="sidenavCard">
            <img class="w-50 mx-auto" src="/img/illustrations/icon-documentation-warning.svg" alt="sidebar_illustration">
            <div class="card-body text-center p-3 w-100 pt-0">
                <div class="docs-info">
                    <h6 class="mb-0">Need help?</h6>
                    <p class="text-xs font-weight-bold mb-0">Please check our docs</p>
                </div>
            </div>
        </div>
        <a href="/docs/bootstrap/overview/argon-dashboard/index.html" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">
            Documentation
        </a>
        <a class="btn btn-primary btn-sm w-100" href="https://www.creative-tim.com/product/argon-dashboard-pro-laravel" target="_blank">
            Upgrade to PRO
        </a>
    </div>
</aside>