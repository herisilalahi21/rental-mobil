@extends('layout.admin')

@section('title', 'Kelola Data Mobil')

@section('content')
<style>
    /* --- CSS PISAHAN UNTUK KOTAK STATISTIK & TABEL --- */
    .mobil-page-wrapper {
        font-family: 'Inter', sans-serif;
        color: #1a1d2d;
    }

    /* Row Kotak-Kotak Statistik */
    .stat-container {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card-box {
        flex: 1;
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        border: none;
    }

    .stat-card-box .label {
        font-size: 11px;
        font-weight: 700;
        color: #adb5bd;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .stat-card-box .value {
        font-size: 28px;
        font-weight: 800;
        line-height: 1;
    }

    /* Warna Teks Spesifik */
    .text-success-custom { color: #10b981; }
    .text-warning-custom { color: #f59e0b; }
    .text-danger-custom { color: #ef4444; }

    /* Filter & Search Bar */
    .action-bar {
        background: #fff;
        border-radius: 12px;
        padding: 15px 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .search-wrapper {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-wrapper i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #ccc;
    }

    .search-wrapper input {
        width: 100%;
        padding: 10px 15px 10px 45px;
        border-radius: 10px;
        border: 1px solid #f1f1f1;
        font-size: 14px;
    }

    .filter-dropdown {
        padding: 10px 15px;
        border-radius: 10px;
        border: 1px solid #f1f1f1;
        background: #fff;
        font-size: 13px;
        color: #666;
    }

    /* Tabel Data */
    .data-table-wrapper {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .table thead th {
        background: #fcfcfc;
        padding: 15px 20px;
        font-size: 11px;
        font-weight: 700;
        color: #adb5bd;
        text-transform: uppercase;
        border-bottom: 1px solid #f8f9fa;
    }

    .table tbody td {
        padding: 18px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
        font-size: 14px;
    }

    /* Badge Status */
    .status-pill {
        padding: 6px 15px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        display: inline-block;
    }
    .status-tersedia { background: #e6f4ea; color: #1e7e34; }
    .status-disewa { background: #fff4e5; color: #b45d00; }
    .status-bermasalah { background: #fdeaea; color: #c62828; }

    /* Tombol Aksi */
    .btn-action-detail {
        color: #3366ff;
        background: #eef2ff;
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        font-size: 12px;
    }

    .btn-action-hapus {
        color: #ff4d4d;
        background: #fff5f5;
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        font-size: 12px;
    }
</style>

<div class="mobil-page-wrapper">
    <h4 class="fw-bold mb-4">Kelola Data Mobil</h4>

    <div class="stat-container">
        <div class="stat-card-box">
            <div class="label">Total Mobil</div>
            <div class="value">{{ number_format($totalMobil, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card-box">
            <div class="label text-success-custom">Tersedia</div>
            <div class="value text-success-custom">{{ number_format($tersedia, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card-box">
            <div class="label text-warning-custom">Sedang Disewa</div>
            <div class="value text-warning-custom">{{ number_format($disewa, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card-box">
            <div class="label text-danger-custom">Bermasalah</div>
            <div class="value text-danger-custom">{{ number_format($maintenance, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="action-bar">
        <div class="search-wrapper">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Cari nama mobil, plat, atau owner...">
        </div>
        <select class="filter-dropdown"><option>Kategori</option></select>
        <select class="filter-dropdown"><option>Status</option></select>
        <select class="filter-dropdown"><option>Owner</option></select>
    </div>

    <div class="data-table-wrapper">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Mobil</th>
                        <th>Kategori</th>
                        <th>Owner</th>
                        <th>Harga / Hari</th>
                        <th>Booking</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mobil as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <img src="{{ asset('storage/' . $item->foto) }}" width="30" alt="">
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $item->nama_mobil }}</div>
                                    <small class="text-muted">{{ $item->plat_nomor }} • {{ $item->tahun }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $item->kategori }}</td>
                        <td>
                            <div class="fw-bold">{{ $item->owner->nama ?? 'N/A' }}</div>
                            <small class="text-warning">★ 4.9</small>
                        </td>
                        <td class="fw-bold">Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}</td>
                        <td class="text-muted">{{ $item->transaksis_count }} sewa</td>
                        <td>
                            <span class="status-pill status-{{ strtolower($item->status) }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.mobil.detail', $item->id) }}" class="btn-action-detail me-1">Detail</a>
                            <button class="btn-action-hapus">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Data mobil belum tersedia, Boy.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 d-flex justify-content-between align-items-center border-top">
            <small class="text-muted">Menampilkan 1-{{ $mobil->count() }} dari {{ $mobil->total() }} mobil</small>
            <div>
                {{ $mobil->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
