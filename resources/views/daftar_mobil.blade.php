@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="main-wrapper">
    <header class="page-header">
        <div class="container">
            <h1>Daftar Mobil</h1>
            <p>Armada siap tempur untuk kebutuhan Anda.</p>
        </div>
    </header>

    <section class="search-filter">
        <div class="container">
            <form action="{{ route('mobil.index') }}" method="GET" class="filter-card">
                <input type="text" name="search" placeholder="Cari mobil..." value="{{ request('search') }}" style="flex: 3; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                
                <select name="kategori" style="flex: 1; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <option value="">Semua Kategori</option>
                    <option value="MPV" {{ request('kategori') == 'MPV' ? 'selected' : '' }}>MPV</option>
                    <option value="SUV" {{ request('kategori') == 'SUV' ? 'selected' : '' }}>SUV</option>
                </select>

                <button type="submit" style="flex: 1; background: #2563eb; color: white; padding: 12px; border-radius: 10px; border: none; font-weight: 700; cursor: pointer;">
                    Cari Sekarang
                </button>
            </form>
        </div>
    </section>

    <main class="container">
        <div class="car-grid">
            @forelse($mobils as $mobil)
                <div class="car-card">
                    @php
                        $colors = ['#e0f7fa', '#fce4ec', '#e8eaf6', '#fff9c4'];
                        $bg = $colors[$loop->index % 4];
                    @endphp
                    
                    <div class="car-header-color" style="background: {{ $bg }};">
                        <span class="badge-status">TERSEDIA</span>
                    </div>

                    <div class="car-info">
                        <span class="category-badge">{{ $mobil->kategori }}</span>
                        <h3 style="margin: 0 0 5px 0; font-weight: 800;">{{ $mobil->nama_mobil }}</h3>
                        <p style="margin: 0; color: #94a3b8; font-size: 13px;">{{ $mobil->transmisi }} • 7 Seater</p>
                        
                        <div class="price-section">
                            <div>
                                <p style="margin: 0; font-size: 10px; color: #94a3b8; font-weight: 600;">HARGA SEWA</p>
                                <strong>Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}</strong>
                                <span style="font-size: 11px; color: #94a3b8;">/hari</span>
                            </div>
                            <div style="color: #f59e0b; font-weight: 800;">⭐ 4.9</div>
                        </div>

                        <a href="{{ route('mobil.show', $mobil->id_mobil) }}" class="btn-detail">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 50px;">
                    <p style="color: #94a3b8;">Mobil tidak ditemukan.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection