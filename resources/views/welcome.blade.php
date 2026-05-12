@extends('layouts.app')

@section('title', 'Sewa Mobil Mudah & Cepat')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rencar.css') }}">
    <style>
        .btn-booking {
            display: block;
            width: 100%;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 15px;
            border: none;
        }
        .btn-booking:hover {
            background-color: #0056b3;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }
        .btn-booked-now {
            display: block;
            width: 100%;
            background-color: #e9ecef;
            color: #6c757d;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: not-allowed;
            margin-top: 15px;
        }
    </style>
@endpush

@section('content')
    {{-- BAGIAN HERO --}}
    <header class="hero"> 
        <div class="container hero-container">
            <div class="hero-content">
                <h1>Sewa Mobil Mudah <br>& <span class="highlight">Cepat.</span></h1>
                <p>Pilih dari ribuan mobil terverifikasi. Booking online, ambil di kota Anda — semua dalam hitungan menit.</p>
                
                <div class="hero-actions">
                    <a href="{{ route('mobil.umum') }}" class="btn-blue">Lihat Mobil <span class="arrow">→</span></a>
                    <a href="#car-selection" class="btn-white">Booking Sekarang</a>
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
    <section class="car-selection" id="car-selection">
        <div class="container">
            <div class="section-header">
                <div class="header-text">
                    <span class="label">PILIHAN MOBIL</span>
                    <h2>Mobil Pilihan untuk Anda</h2>
                </div>
                <a href="{{ route('mobil.umum') }}" class="btn-outline-small">Lihat Semua →</a>
            </div>

            <div class="car-grid">
                @forelse($mobil as $item)
                <div class="car-card">
                    <div class="car-thumb">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_mobil }}" class="car-img">
                        @else
                            <img src="{{ asset('images/default-car.jpg') }}" alt="No Image" class="car-img">
                        @endif
                        
                        <span class="badge {{ $item->status == 'tersedia' ? 'badge-available' : 'badge-booked' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <div class="car-info">
                        <h3>{{ $item->nama_mobil }}</h3>
                        <p>{{ $item->kategori }} • {{ $item->transmisi }} • {{ $item->tahun }}</p>
                        
                        <div class="price-row">
                            {{-- PERBAIKAN: Harga murni dari database dengan format Rupiah --}}
                            <strong>Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}<span>/hari</span></strong>
                            <span class="rating">★ 4.9</span>
                        </div>

                        {{-- LOGIKA TOMBOL BOOKING --}}
                        @if($item->status == 'tersedia')
                            @auth
                                <a href="{{ route('booking.create', $item->id) }}" class="btn-booking">
                                    Booking Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-booking" onclick="alert('Silakan login terlebih dahulu untuk melakukan booking')">
                                    Booking Sekarang
                                </a>
                            @endauth
                        @else
                            <div class="btn-booked-now">Tidak Tersedia</div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="no-data">Belum ada mobil tersedia saat ini.</div>
                @endforelse
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
                    <p>Pesan mobil dalam 3 langkah: pilih, bayar, ambil.</p>
                </div>
                <div class="benefit-card dark-card">
                    <div class="icon-box yellow-box">🚗</div>
                    <h4>Banyak Pilihan Mobil</h4>
                    <p>Ribuan unit terverifikasi untuk kebutuhan Anda.</p>
                </div>
                <div class="benefit-card">
                    <div class="icon-box green-box">🕒</div>
                    <h4>Proses Cepat</h4>
                    <p>Konfirmasi kilat dan layanan pelanggan 24/7.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
