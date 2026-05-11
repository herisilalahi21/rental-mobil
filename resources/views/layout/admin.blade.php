<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RentaCar</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/admin/layout.css') }}">
    
    {{-- Tempat CSS spesifik halaman (Dashboard, User Data, atau Owner) --}}
    @stack('styles')
</head>
<body>

    <aside class="sidebar">
        <div class="brand">
            <div class="logo-box">R</div>
            <div>
                <strong style="color:white; display:block;">RentaCar</strong>
                <span style="color:#F59E0B; font-size:10px; font-weight:700;">SUPER ADMIN</span>
            </div>
        </div>

        <nav class="nav-menu">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                Dashboard
            </a>

            {{-- Data User --}}
            <a href="{{ route('admin.users') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                Data User
            </a>

            {{-- Owner (Sudah Sinkron dengan route baru: admin.owner) --}}
            <a href="{{ route('admin.owner') }}" class="{{ request()->is('admin/owner*') ? 'active' : '' }}">
                Owner 
                @if(($ownerPendingCount ?? 0) > 0) 
                    <span class="badge-orange">{{ $ownerPendingCount }}</span> 
                @endif
            </a>

           <a href="{{ route('admin.mobil') }}">Data Mobil</a>
            <a href="{{ route('admin.transactions') }}">Transaksi</a>

            <a href="{{ route('admin.laporan')}}">Laporan Sistem</a>
            <a href="#">Review</a>
            
            {{-- Form Logout dengan styling yang disesuaikan --}}
            <form action="{{ route('logout') }}" method="POST" style="margin-top: 50px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:#EF4444; cursor:pointer; font-weight:700; padding:12px; width:100%; text-align:left; font-family: inherit; font-size: 14px; transition: 0.3s;">
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    <main class="main-content">
        <header class="header">
            <h2 style="margin:0; font-weight:800; color:#1E293B; letter-spacing:-0.5px;">@yield('header_title')</h2>
            
            <div class="user-profile" style="display: flex; align-items: center; gap: 12px;">
                <div style="text-align:right;">
                    <strong style="display:block; font-size:13px; color: #1E293B;">{{ Auth::user()->nama }}</strong>
                    <span style="color:#EF4444; font-size:11px; font-weight:600;">Administrator</span>
                </div>
                {{-- Inisial Nama untuk Avatar --}}
                <div class="avatar-sa" style="background:#FEE2E2; color:#EF4444; width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size: 12px;">
                    SA
                </div>
            </div>
        </header>

        {{-- Tempat Masuknya Konten dari file seperti dashboard.blade.php atau owner.blade.php --}}
        @yield('content')
    </main>

    {{-- Tempat Script Tambahan (Seperti Chart.js di Dashboard) --}}
    @stack('scripts')
</body>
</html>