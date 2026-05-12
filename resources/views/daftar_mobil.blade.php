@extends('layouts.app')

@section('title', 'Daftar Mobil - RentaCar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rencar.css') }}">
    <style>
        /* Header Hero */
        .hero-header {
            background: #1a1a1a;
            padding: 60px 0;
            margin-bottom: 0;
        }

        /* Filter Section */
        .filter-section {
            background: #fff;
            padding: 25px 0;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .filter-container {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }
        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f8f9fa;
        }
        .filter-select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            min-width: 160px;
        }
        .btn-filter-submit {
            background: #1a1a1a;
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-filter-submit:hover {
            background: #333;
        }

        /* Active Tags */
        .active-filters {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        .filter-tag {
            background: #eef4ff;
            color: #007bff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #d0e1ff;
        }

        /* Car Card Grid */
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        .car-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid #eee;
            transition: transform 0.3s;
        }
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .car-thumb {
            position: relative;
            height: 200px;
        }
        .car-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .badge-status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-tersedia { background: #d1fae5; color: #065f46; }
        .status-disewa { background: #fee2e2; color: #991b1b; }

        .car-info { padding: 20px; }
        .car-info h3 { font-size: 18px; margin-bottom: 5px; font-weight: 700; color: #1a1a1a; }
        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }
        .price-row strong { font-size: 18px; color: #007bff; }
        .price-row strong span { font-size: 13px; color: #666; font-weight: 400; }

        .btn-detail {
            display: block;
            width: 100%;
            background: #1a1a1a;
            color: #fff;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 15px;
            transition: 0.3s;
        }
        .btn-detail:hover { background: #333; color: #fff; }
    </style>
@endpush

@section('content')
{{-- HERO HEADER --}}
<div class="hero-header text-white">
    <div class="container text-center">
        <h1 class="display-5 fw-bold">Daftar Mobil</h1>
        <p class="text-secondary mb-0">Temukan armada terbaik untuk perjalanan Anda di Siborong-borong dan sekitarnya.</p>
    </div>
</div>

{{-- FILTER SECTION --}}
<section class="filter-section">
    <div class="container">
        <form action="{{ route('mobil.umum') }}" method="GET">
            <div class="filter-container">
                <input type="text" name="search" class="search-input" placeholder="Cari mobil (e.g. Innova, Civic)..." value="{{ request('search') }}">
                
                <select name="kategori" class="filter-select">
                    <option value="">Semua Kategori</option>
                    <option value="SUV" {{ request('kategori') == 'SUV' ? 'selected' : '' }}>SUV</option>
                    <option value="MPV" {{ request('kategori') == 'MPV' ? 'selected' : '' }}>MPV</option>
                    <option value="Sedan" {{ request('kategori') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                </select>

                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                </select>

                <button type="submit" class="btn-filter-submit">Terapkan</button>
            </div>
        </form>

        {{-- FILTER TAGS (Muncul hanya jika ada filter aktif) --}}
        @if(request()->anyFilled(['search', 'kategori', 'status']))
        <div class="active-filters">
            <span class="text-secondary small">Filter aktif:</span>
            @if(request('search')) <div class="filter-tag">"{{ request('search') }}"</div> @endif
            @if(request('kategori')) <div class="filter-tag">{{ request('kategori') }}</div> @endif
            @if(request('status')) <div class="filter-tag">{{ ucfirst(request('status')) }}</div> @endif
            <a href="{{ route('mobil.umum') }}" class="text-danger small ms-2" style="text-decoration:none">Hapus semua</a>
            <span class="ms-auto text-secondary small">Menampilkan <strong>{{ $mobil->total() }}</strong> mobil</span>
        </div>
        @endif
    </div>
</section>

{{-- CAR GRID --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="car-grid">
            @forelse($mobil as $item)
            <div class="car-card">
                <div class="car-thumb">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_mobil }}" class="car-img">
                    @else
                        <img src="{{ asset('images/default-car.jpg') }}" alt="No Image" class="car-img">
                    @endif
                    
                    <span class="badge-status {{ $item->status == 'tersedia' ? 'status-tersedia' : 'status-disewa' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>
                <div class="car-info">
                    <h3>{{ $item->nama_mobil }}</h3>
                    <p class="text-muted small mb-0">{{ $item->kategori }} • {{ $item->transmisi }} • {{ $item->tahun }}</p>
                    
                    <div class="price-row">
                        <strong>Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}<span>/hari</span></strong>
                        <span class="text-warning small">★ 4.9</span>
                    </div>

                    <a href="{{ route('booking.create', $item->id) }}" class="btn-detail">
                        Detail Mobil →
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-5 w-100">
                <img src="{{ asset('images/not-found.svg') }}" alt="Empty" style="width: 150px; opacity: 0.5;">
                <h4 class="mt-3 text-secondary">Mobil tidak ditemukan</h4>
                <p>Coba gunakan kata kunci atau filter yang berbeda.</p>
                <a href="{{ route('mobil.umum') }}" class="btn btn-dark">Reset Filter</a>
            </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $mobil->links() }}
        </div>
    </div>
</section>
@endsection