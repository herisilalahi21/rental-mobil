<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'RenCar - Sewa Mobil Mudah')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }

        /* Navigasi Sesuai Gambar */
        .navbar-custom {
            background: white;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo {
            background: #2563EB; /* Biru sesuai logo R di gambar */
            color: white;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: 800;
            font-size: 20px;
        }

        .brand-name {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
            margin: 0;
            padding: 0;
        }

        .nav-menu a {
            text-decoration: none;
            color: #64748b;
            font-weight: 500;
            font-size: 15px;
            transition: 0.3s;
        }

        .nav-menu a:hover, .nav-menu a.active {
            color: #2563EB;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Status Badge Guest Mode */
        .mode-badge {
            background: #f1f5f9;
            color: #64748b;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Button Sesuai Gambar */
        .btn-login-outline {
            padding: 8px 25px;
            border: 1px solid #2563EB;
            color: #2563EB;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-login-outline:hover {
            background: #f0f7ff;
        }

        .btn-register-solid {
            padding: 9px 25px;
            background: #2563EB;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
            border: none;
        }

        .btn-register-solid:hover {
            background: #1d4ed8;
            color: white;
        }

        footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 40px 5%;
            text-align: center;
            font-size: 14px;
        }

        /* Utility classes */
        .text-blue { color: #2563EB; }
    </style>

    @stack('styles')
</head>
<body>

    <nav class="navbar-custom">
        <a href="{{ route('home') }}" class="brand-wrapper">
            <div class="brand-logo">R</div>
            <span class="brand-name">RentaCar</span>
        </a>

        <ul class="nav-menu">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('mobil.umum') }}" class="{{ request()->routeIs('mobil.umum') ? 'active' : '' }}">Daftar Mobil</a></li>
            <li><a href="#">Tentang Kami</a></li>
        </ul>

        <div class="nav-actions">
            @guest
                
                <a href="{{ route('login') }}" class="btn-login-outline">Login</a>
                <a href="{{ route('register') }}" class="btn-register-solid">Daftar Sekarang</a>
            @else
                <div class="mode-badge">● MODE {{ strtoupper(Auth::user()->role) }}</div>
                @if(Auth::user()->role == 'owner')
                    <a href="{{ route('owner.dashboard') }}" class="btn-register-solid">Dashboard Owner</a>
                @elseif(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-register-solid">Dashboard Admin</a>
                @endif
                
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger text-decoration-none fw-bold small">Logout</button>
                </form>
            @endguest
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} <strong>RentaCar Marketplace</strong>. Built for Google Student Ambassador 2026 Project.</p>
            <small>Siborong-borong, Sumatera Utara</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>