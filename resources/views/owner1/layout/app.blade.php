<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - RentACar</title>
    
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
    @stack('styles')
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="nav-brand">
            <div style="background: #2563EB; color: white; padding: 5px 10px; border-radius: 8px;">R</div>
            <span>RentaCar</span>
        </div>

        <div class="nav-links">
            <a href="#" class="active">Dashboard</a>
            <a href="#">Daftar Mobil</a>
            <a href="#">Riwayat Penyewaan</a>
            <a href="#">Kelola Mobil</a>
            <a href="#">Kelola Booking</a>
            <a href="#">Profile</a>
            <a href="#">Review</a>
        </div>

        <div class="profile-section">
            <div style="text-align: right">
                <div style="font-size: 0.85rem; font-weight: 600;">najwa.s</div>
                <div style="font-size: 0.7rem; color: #64748B;">Owner</div>
            </div>
            <div class="avatar">NS</div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>