<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RentaCar</title>

    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('styles')
</head>

<body>

<nav class="navbar" style="position: relative; z-index: 1000; background: white;">
    <div class="container nav-flex">
        <div class="brand"><strong>RentaCar</strong></div>
        <ul class="menu">
            <li><a href="/" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('mobil.index') }}" class="{{ Request::is('daftar-mobil*') ? 'active' : '' }}">Daftar Mobil</a></li>
        </ul>
        
        <div class="nav-auth" style="display: flex; gap: 10px; align-items: center;">
            {{-- GUNAKAN LOGIKA @guest UNTUK CEK STATUS LOGIN --}}
            @guest
                {{-- Jika Belum Login, Tampilkan Tombol Ini --}}
                <a href="{{ route('login') }}" class="btn-outline">Login</a>
                <a href="{{ route('register') }}" class="btn-filled">Daftar Sekarang</a>
            @else
                {{-- Jika Sudah Login, Tampilkan Nama & Tombol Logout --}}
                <span style="font-size: 14px; font-weight: 600;">Halo, {{ Auth::user()->nama }}</span>
                
                {{-- Logout HARUS pakai Form & Method POST agar tidak error --}}
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-outline" style="border-color: red; color: red; cursor: pointer;">
                        Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</nav>

<main style="position: relative; z-index: 1;">
    @yield('content')
</main>

@stack('scripts')
</body>
</html>