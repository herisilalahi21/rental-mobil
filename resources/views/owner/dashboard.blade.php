@extends('owner.layouts.tampilan')

@section('title', 'Dashboard Owner')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/owner/dashboard.css') }}">
@endpush

@section('content')
<div class="welcome-section" style="margin-bottom: 2rem;">
    <h1 style="font-weight: 700;">Selamat datang kembali, {{ Auth::user()->nama }} 👋</h1>
    <p>Berikut ringkasan armada dan booking Anda hari ini.</p>
</div>

{{-- Statistik Atas --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="icon-box blue">M</div>
        <div>
            <small>TOTAL MOBIL</small>
            <h3 class="value" style="font-size: 1.5rem; font-weight: 700; margin: 0;">{{ $jumlahMobil ?? 0 }}</h3>
        </div>
    </div>

    <div class="stat-card">
        <div class="icon-box yellow">P</div>
        <div>
            <small>PERMINTAAN BOOKING</small>
            <h3 class="value" style="font-size: 1.5rem; font-weight: 700; margin: 0;">{{ $bookings->count() }}</h3>
        </div>
    </div>

    <div class="stat-card income-card">
        <div class="icon-box dark-yellow">$</div>
        <div>
            <small style="color: #94A3B8;">PENDAPATAN BULAN INI</small>
            <h3 class="value" style="font-size: 1.5rem; font-weight: 700; margin: 0;">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<div class="main-grid">
    {{-- Grafik Pendapatan --}}
    <div class="chart-section">
        <div class="section-header">
            <div style="display: flex; flex-direction: column;">
                <h4 style="font-weight: 700; margin: 0;">Pendapatan 6 Bulan Terakhir</h4>
                <small style="color: #64748B; font-size: 0.75rem;">Dalam jutaan rupiah</small>
            </div>
            <span style="background: #0F172A; color: white; padding: 4px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">6 Bulan</span>
        </div>
        {{-- Placeholder Chart --}}
        <div style="height: 200px; display: flex; align-items: flex-end; justify-content: space-between; padding-top: 20px;">
            <div style="width: 40px; height: 40%; background: #EFF6FF; border-radius: 4px;"></div>
            <div style="width: 40px; height: 70%; background: #EFF6FF; border-radius: 4px;"></div>
            <div style="width: 40px; height: 50%; background: #EFF6FF; border-radius: 4px;"></div>
            <div style="width: 40px; height: 85%; background: #2563EB; border-radius: 4px;"></div>
            <div style="width: 40px; height: 60%; background: #EFF6FF; border-radius: 4px;"></div>
            <div style="width: 40px; height: 95%; background: #2563EB; border-radius: 4px;"></div>
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 10px; color: #94A3B8; font-size: 0.7rem;">
            <span>Des</span><span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><strong style="color: #1E293B;">Mei</strong>
        </div>
    </div>

    {{-- Permintaan Booking --}}
    <div class="booking-section">
        <div class="section-header">
            <h4 style="font-weight: 700; margin: 0;">Permintaan Booking</h4>
            <a href="#" style="color: #2563EB; font-size: 0.8rem; font-weight: 600; text-decoration: none;">Lihat semua</a>
        </div>
        
        <div class="booking-list" style="margin-top: 1rem;">
            @forelse($bookings as $book)
            <div class="booking-item">
                <div class="avatar-small" style="background: #FEE2E2; color: #EF4444;">
                    {{ strtoupper(substr($book->user->nama, 0, 2)) }}
                </div>
                <div class="item-info">
                    <strong style="display: block;">{{ $book->user->nama }}</strong>
                    <small style="color: #64748B;">{{ $book->mobil->nama_mobil }} • {{ date('d-m M', strtotime($book->tgl_mulai)) }}</small>
                </div>
                <button class="btn-terima">Terima</button>
            </div>
            @empty
            <p style="text-align: center; color: #94A3B8; font-size: 0.85rem;">Tidak ada permintaan baru.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Tambahan: Performa Mobil (Section Bawah di Gambar) --}}
<div class="performa-mobil" style="margin-top: 2rem;">
    <div class="section-header">
        <h4 style="font-weight: 700;">Performa Mobil Anda</h4>
        <a href="#" style="color: #2563EB; font-size: 0.8rem; font-weight: 600; text-decoration: none;">Kelola Mobil &rarr;</a>
    </div>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 1rem;">
        {{-- Card Mobil (Looping dari database nanti) --}}
        <div style="background: white; padding: 15px; border-radius: 12px; border: 1px solid #E2E8F0;">
            <div style="width: 100%; height: 80px; background: #E0F2FE; border-radius: 8px; margin-bottom: 10px;"></div>
            <strong style="display: block; font-size: 0.85rem;">Toyota Innova</strong>
            <small style="color: #64748B; font-size: 0.75rem;">12 sewa bulan ini</small>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                <span style="color: #10B981; font-weight: 700; font-size: 0.85rem;">Rp 7.800.000</span>
                <span style="color: #F59E0B; font-size: 0.75rem;">★ 4.9</span>
            </div>
        </div>
        {{-- Tombol Tambah --}}
       {{-- Ganti bagian ini di dashboard --}}
<a href="{{ route('owner.mobil.create') }}" style="text-decoration: none; border: 2px dashed #E2E8F0; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 12px; cursor: pointer;">
    <span style="font-size: 1.5rem; color: #94A3B8;">+</span>
    <small style="color: #94A3B8;">Tambah Mobil Baru</small>
</a>
    </div>
</div>
@endsection