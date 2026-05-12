<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RentACar</title>
    
    <link rel="stylesheet" href="{{ asset('css/owner/tampilan.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>

    <nav class="navbar">
        <div class="nav-brand">
            <div class="logo-box">R</div>
            <span>RentaCar</span>
        </div>

        <div class="nav-links">
            {{-- 1. Dashboard --}}
            <a href="{{ route('owner.dashboard') }}" 
               class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
               Dashboard
            </a>

            {{-- 2. Daftar Mobil (INI YANG SUDAH DIPERBAIKI) --}}
            <a href="{{ route('owner.daftar_mobil') }}" 
               class="{{ request()->routeIs('owner.daftar_mobil') ? 'active' : '' }}">
               Daftar Mobil
            </a>

            {{-- 3. Kelola/Tambah Mobil --}}
            <a href="{{ route('owner.mobil.create') }}" 
               class="{{ request()->routeIs('owner.mobil.create') ? 'active' : '' }}">
               kelolah mobil
            </a>

            <a href="#">Riwayat Penyewaan</a>
            <a href="#">Kelola Booking</a>
            <a href="#">Profile</a>
            <a href="#">Review</a>
        </div>

        <div class="profile-section">
            <div class="profile-info">
                <div class="username">{{ Auth::user()->nama }}</div>
                <div class="role">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
            <div class="avatar">
                {{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}
            </div>
            
            <form action="{{ route('logout') }}" method="POST" style="margin-left: 10px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:#EF4444; cursor:pointer; font-size:12px; font-weight: 600;">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="container">
        {{-- Flash Message buat notifikasi sukses/gagal --}}
        @if(session('success'))
            <div style="padding: 15px; background: #DCFCE7; color: #166534; border-radius: 10px; margin-bottom: 20px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>