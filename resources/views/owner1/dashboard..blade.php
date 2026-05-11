@extends('layouts.owner')

@section('content')
<header style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.5rem; margin-bottom: 0.5rem;">
        Selamat datang kembali, {{ Auth::user()->name }} 👋
    </h1>
    <p style="color: #64748B; font-size: 0.9rem;">Berikut ringkasan armada dan booking Anda hari ini.</p>
</header>

<div class="dashboard-content">
    <div class="stats-grid">
        <div class="card-stat">
            <span class="label">Total Mobil</span>
            <h2 class="value">{{ $totalMobil ?? '0' }}</h2>
        </div>
        <div class="card-stat">
            <span class="label">Permintaan Booking</span>
            <h2 class="value">{{ $totalBooking ?? '0' }}</h2>
        </div>
        <div class="card-stat card-dark">
            <span class="label">Pendapatan Bulan Ini</span>
            <h2 class="value">Rp {{ number_with_delimiter($pendapatan ?? 0) }}</h2>
        </div>
    </div>

    <div class="main-content-grid">
        <div class="chart-container">
            <h3>Pendapatan 6 Bulan Terakhir</h3>
            <div class="chart-box"></div>
        </div>
        
        <div class="booking-list">
            <h3>Permintaan Booking</h3>
            @forelse($bookings as $booking)
                <div class="booking-item">
                    <div class="user-info">
                        <strong>{{ $booking->user->name }}</strong>
                        <small>{{ $booking->mobil->nama }} • {{ $booking->tanggal }}</small>
                    </div>
                    <button class="btn-terima">Terima</button>
                </div>
            @empty
                <p>Tidak ada permintaan booking baru.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection