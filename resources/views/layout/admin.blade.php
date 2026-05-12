<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RentaCar Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/layout.css') }}">
    
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
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            {{-- Data User --}}
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') && !request('role') ? 'active' : '' }}">
                Data User
            </a>

            {{-- Data Owner (Menggunakan parameter role) --}}
            <a href="{{ route('admin.users', ['role' => 'owner']) }}" class="{{ request('role') == 'owner' ? 'active' : '' }}">
                Data Owner 
                @if(($ownerPendingCount ?? 0) > 0) 
                    <span class="badge-orange">{{ $ownerPendingCount }}</span> 
                @endif
            </a>

            {{-- Data Mobil --}}
            <a href="{{ route('admin.mobil') }}" class="{{ request()->routeIs('admin.mobil*') ? 'active' : '' }}">
                Data Mobil
            </a>

            {{-- Transaksi (SINKRON DENGAN WEB.PHP) --}}
            <a href="{{ route('admin.transactions') }}" class="{{ request()->routeIs('admin.transactions*') ? 'active' : '' }}">
                Transaksi
            </a>

            {{-- Laporan (DIUBAH DARI admin.laporan KE admin.reports AGAR SINKRON) --}}
            <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                Laporan Sistem
            </a>
            
            {{-- Form Logout --}}
            <form action="{{ route('logout') }}" method="POST" style="margin-top: 50px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:#EF4444; cursor:pointer; font-weight:700; padding:12px; width:100%; text-align:left; font-family: inherit; font-size: 14px; transition: 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
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
                    {{-- Gunakan property 'name' atau 'nama' sesuai database lo --}}
                    <strong style="display:block; font-size:13px; color: #1E293B;">{{ Auth::user()->name ?? Auth::user()->nama }}</strong>
                    <span style="color:#EF4444; font-size:11px; font-weight:600;">{{ strtoupper(Auth::user()->role) }}</span>
                </div>
                
                <div class="avatar-sa" style="background:#FEE2E2; color:#EF4444; width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size: 12px;">
                    {{ substr(Auth::user()->name ?? Auth::user()->nama, 0, 2) }}
                </div>
            </div>
        </header>

        <div class="content-body" style="padding: 24px;">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>