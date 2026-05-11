@extends('layout.admin')

@section('title', 'Kelola Mobil')
@section('page_title', 'Kelola Data Mobil')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/data_mobil.css') }}">
@endpush

@section('content')
    <section class="user-stats-grid">
        <div class="user-stat-card">
            <div>
                <span class="stat-label">TOTAL MOBIL</span>
                <strong class="stat-value">{{ number_format($stats['total']) }}</strong>
            </div>
        </div>
        <div class="user-stat-card">
            <div>
                <span class="stat-label" style="color: #10B981;">TERSEDIA</span>
                <strong class="stat-value" style="color: #10B981;">{{ number_format($stats['tersedia']) }}</strong>
            </div>
        </div>
        <div class="user-stat-card">
            <div>
                <span class="stat-label" style="color: #F59E0B;">SEDANG DISEWA</span>
                <strong class="stat-value" style="color: #F59E0B;">{{ number_format($stats['disewa']) }}</strong>
            </div>
        </div>
        <div class="user-stat-card">
            <div>
                <span class="stat-label" style="color: #EF4444;">DILAPORKAN BERMASALAH</span>
                <strong class="stat-value" style="color: #EF4444;">{{ $stats['bermasalah'] }}</strong>
            </div>
        </div>
    </section>

    <div class="table-container">
        <div class="table-header">
            <form class="filter-form">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" placeholder="Cari nama mobil, plat, atau owner..." class="search-input">
                </div>
                <select class="select-filter"><option>Kategori</option></select>
                <select class="select-filter"><option>Status</option></select>
                <select class="select-filter"><option>Owner</option></select>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>MOBIL</th>
                    <th>KATEGORI</th>
                    <th>OWNER</th>
                    <th>HARGA / HARI</th>
                    <th>BOOKING</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mobil as $item)
                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar" style="background: #E0F2FE; border-radius: 8px;">🚗</div>
                            <div>
                                <div class="user-name">{{ $item->nama_mobil }}</div>
                                <div class="user-id">{{ $item->plat_nomor }} • {{ $item->tahun }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $item->kategori }}</td>
                    <td>
                        <div class="user-name">{{ $item->owner->nama }}</div>
                        <div class="user-id">⭐ {{ $item->owner->rating }}</div>
                    </td>
                    <td style="font-weight: 700;">Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}</td>
                    <td>{{ $item->total_booking }} sewa</td>
                    <td>
                        <span class="badge-status badge-{{ strtolower($item->status) }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="action-wrapper">
                            <a href="{{ route('admin.mobil.detail', $item->id_mobil) }}" class="btn-detail">Detail</a>
                            <form action="{{ route('admin.mobil.delete', $item->id_mobil) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-edit" style="background:none; border:none; color:var(--danger); cursor:pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection