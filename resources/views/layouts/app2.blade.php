<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Etalase Barang')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Sliders --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        :root {
            --primary: #f97316;
            --dark: #18181b;
            --light: #f4f4f5;
        }

        body {
            background-color: #f8f9fa;
            padding-top: 50px;
            background-color: var(--light);
        }

        .navbar {
            background-color: var(--dark) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 40px;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            position: relative;
            margin: 0 8px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary) !important;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2px;
            background-color: var(--primary);
        }

        .search-box {
            position: relative;
            margin: 0 0 0 10px;
            min-width: 250px;
        }

        .search-input {
            border-radius: 20px;
            padding-left: 40px;
            border: none;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .search-input:focus {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: none;
        }

        .search-input::placeholder {
            color: #6b6b6b !important;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            z-index: 10;
        }

        .btn-search {
            background-color: var(--primary);
            color: white;
            border-radius: 20px;
            padding: 5px 15px;
            margin-left: 5px;
            border: none;
        }

        .btn-search:hover {
            background-color: #ea580c;
            color: white;
        }

        .ticket-card {
            border-left: 4px solid;
            transition: all 0.2s ease;
        }

        .ticket-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .ticket-waiting {
            border-left-color: var(--primary);
        }

        .ticket-process {
            border-left-color: #fbbf24;
            /* Slightly adjusted orange */
        }

        .ticket-completed {
            border-left-color: #16a34a;
            /* Keeping recognizable green */
        }

        .ticket-missed {
            border-left-color: #dc2626;
            /* Keeping recognizable red */
        }

        .btn-trigger {
            position: fixed;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 999;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: move;
            touch-action: none;
            color: white;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: 0;
        }

        /* Mobile styles */
        @media (max-width: 991px) {
            .search-box {
                margin: 10px 0;
                width: 100%;
                min-width: auto;
            }

            .btn-search {
                margin-top: 10px;
                width: 100%;
            }

            .navbar-collapse {
                background-color: var(--dark);
                padding: 15px;
                margin-top: 10px;
                border-radius: 5px;
            }
        }

        #home {
            padding-bottom: 30px;
        }

        .text-orange {
            color: var(--primary) !important;
        }

        .text-gradient {
            background: linear-gradient(to right, #fff, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .blur {
            filter: blur(20px);
        }

        .product-card,
        .card-layanan {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover,
        .card-layanan:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .product-img {
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .fav-btn {
            background: rgba(255, 255, 255, 0.85);
        }

        .btn-orange {
            background-color: var(--primary);
            color: white;
        }

        .btn-orange:hover {
            background-color: #ea580c;
            color: white;
        }

        .btn-outline-orange {
            border-color: #ea580c;
            color: #ea580c;
        }

        .btn-outline-orange:hover {
            background-color: #ea580c;
            color: white;
        }
    </style>
</head>

<body>

    @include('layouts.header2')

    <div class="container-fluid">
        <div class="row">
            @include('layouts.navbars.guest.sidebar')

            <main class="col-lg-12" style="padding: 0;">
                @yield('content')
            </main>
        </div>
    </div>

    @include('layouts.footers.guest.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script>
        // Add pulse animation to notification badge and make button draggable
        document.addEventListener('DOMContentLoaded', function() {
            const badge = document.querySelector('.notification-badge');
            const btn = document.querySelector('.btn-trigger');

            if (badge) {
                // Pulse animation
                function pulse() {
                    badge.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        badge.style.transform = 'scale(1)';
                    }, 500);
                }
                setInterval(pulse, 1000);
            }

            if (btn) {
                // Draggable functionality
                let isDragging = false;
                let offsetX, offsetY;

                btn.addEventListener('mousedown', (e) => {
                    isDragging = true;
                    offsetX = e.clientX - btn.getBoundingClientRect().left;
                    offsetY = e.clientY - btn.getBoundingClientRect().top;
                });

                document.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;
                    btn.style.left = `${e.clientX - offsetX}px`;
                    btn.style.top = `${e.clientY - offsetY}px`;
                });

                document.addEventListener('mouseup', () => {
                    isDragging = false;
                });

                // Make sure button stays within viewport
                document.addEventListener('mouseup', () => {
                    const rect = btn.getBoundingClientRect();
                    if (rect.left < 0) btn.style.left = '20px';
                    if (rect.top < 0) btn.style.top = '100px';
                    if (rect.right > window.innerWidth - 20) btn.style.left =
                        `${window.innerWidth - rect.width - 20}px`;
                    if (rect.bottom > window.innerHeight) btn.style.top =
                        `${window.innerHeight - rect.height}px`;
                });
            }
        });
    </script>

    {{-- Slider --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


</body>

</html>
