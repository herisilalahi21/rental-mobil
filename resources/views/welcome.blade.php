@extends('layouts.app')

@section('title', 'Sewa Mobil Mudah & Cepat')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rencar.css') }}">
@endpush

@section('content')
    {{-- BAGIAN HERO --}}
    <header class="hero"> 
        <div class="container hero-container">
            <div class="hero-content">
                <h1>Sewa Mobil Mudah <br>& <span class="highlight">Cepat.</span></h1>
                <p>Pilih dari ribuan mobil terverifikasi. Booking online, ambil di kota Anda — semua dalam hitungan menit.</p>
                
                <div class="hero-actions">
                    <a href="{{ route('mobil.index') }}" class="btn-blue">Lihat Mobil <span class="arrow">→</span></a>
                    <a href="#" class="btn-white">Booking Sekarang</a>
                </div>

                <div class="hero-stats">
                    <div class="stat">
                        <h3>8.230+</h3>
                        <span>Mobil tersedia</span>
                    </div>
                    <div class="stat">
                        <h3>12.450+</h3>
                        <span>Pengguna aktif</span>
                    </div>
                    <div class="stat">
                        <h3>★ 4,82</h3>
                        <span>Rating rata-rata</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- BAGIAN DAFTAR MOBIL --}}
    <section class="car-selection">
        <div class="container">
            <div class="section-header">
                <div class="header-text">
                    <span class="label">PILIHAN MOBIL</span>
                    <h2>Mobil Pilihan untuk Anda</h2>
                </div>
                <a href="{{ route('mobil.index') }}" class="btn-outline-small">Lihat Semua →</a>
            </div>

            <div class="car-grid">
                <div class="car-card">
                    <div class="car-thumb">
                        <img src="{{ asset('#') }}" alt="Toyota Innova" class="car-img">
                        <span class="badge badge-available">Tersedia</span>
                    </div>
                    <div class="car-info">
                        <h3>Toyota Innova Reborn</h3>
                        <p>MPV • Matic • 7 seater</p>
                        <div class="price-row">
                            <strong>Rp 650rb<span>/hari</span></strong>
                            <span class="rating">★ 4.9</span>
                        </div>
                        <button class="btn-dark">Lihat Detail</button>
                    </div>
                </div>

                <div class="car-card">
                    <div class="car-thumb">
                        <img src="{{ asset('#') }}" alt="Honda Civic" class="car-img">
                        <span class="badge badge-rented">Disewa</span>
                    </div>
                    <div class="car-info">
                        <h3>Honda Civic Type R</h3>
                        <p>Sport • Manual • 4 seater</p>
                        <div class="price-row">
                            <strong>Rp 1,25jt<span>/hari</span></strong>
                            <span class="rating">★ 4.9</span>
                        </div>
                        <button class="btn-dark">Lihat Detail</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BAGIAN BENEFITS --}}
    <section class="benefits-section">
        <div class="container">
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="icon-box blue-box">💳</div>
                    <h4>Mudah Digunakan</h4>
                    <p>Pesan mobil dalam 3 langkah: pilih, bayar, ambil. Antarmuka intuitif.</p>
                </div>
                <div class="benefit-card dark-card">
                    <div class="icon-box yellow-box">M</div>
                    <h4>Banyak Pilihan Mobil</h4>
                    <p>8.230+ unit MPV, SUV, Sedan, hingga Sport. Semua terverifikasi.</p>
                </div>
                <div class="benefit-card">
                    <div class="icon-box green-box">🕒</div>
                    <h4>Proses Cepat</h4>
                    <p>Konfirmasi 1 jam, pembayaran instan, customer service 24/7.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
