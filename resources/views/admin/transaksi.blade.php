@extends('layout.admin')

@section('title', 'Kelola Transaksi')
@section('header_title', 'Kelola Transaksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/transaksi.css') }}">
@endpush

@section('content')
    <div class="transaction-stats">
        <div class="t-card">
            <span>Transaksi Hari Ini</span>
            <h2>{{ $stats['hari_ini'] }}</h2>
        </div>
        <div class="t-card">
            <span>Total Nilai Hari Ini</span>
            <h2>Rp {{ number_format($stats['nilai_hari_ini'] / 1000000, 1, ',', '.') }}jt</h2>
        </div>
        <div class="t-card">
            <span>Transaksi Bermasalah</span>
            <h2 style="color: #ef4444;">{{ $stats['bermasalah'] }}</h2>
        </div>
    </div>

    <div class="table-container">
        <div class="filter-row">
            <input type="text" class="search-box" placeholder="Cari ID transaksi, user, atau mobil...">
            <div style="display: flex; gap: 10px;">
                <button class="btn btn-ktp">📅 Mei 2026</button>
                <button class="btn btn-ktp">Status</button>
                <button class="btn btn-ktp">Export</button>
            </div>
        </div>

        <table class="owner-table">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Penyewa</th>
                    <th>Owner</th>
                    <th>Mobil</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $t)
                <tr>
                    <td>
                        <a href="#" class="tr-id">#TRX-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</a><br>
                        <small style="color: #94a3b8;">{{ $t->created_at->format('d M Y H:i') }}</small>
                    </td>
                    <td>
                        <strong>{{ $t->user->nama }}</strong><br>
                        <small style="color: #94a3b8;">USR-{{ str_pad($t->user->id, 5, '0', STR_PAD_LEFT) }}</small>
                    </td>
                    <td>
                        {{ $t->mobil->user->nama ?? 'Andi Wijaya' }}<br>
                        <small style="color: #94a3b8;">USR-00342</small>
                    </td>
                    <td>
                        {{ $t->mobil->nama_mobil }}<br>
                        <small style="color: #94a3b8;">{{ $t->durasi }} hari</small>
                    </td>
                    <td>{{ $t->tgl_mulai }} - {{ $t->tgl_selesai }}</td>
                    <td>
                        <strong>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</strong><br>
                        <small style="color: #16a34a;">Komisi: Rp {{ number_format($t->total_harga * 0.1, 0, ',', '.') }}</small>
                    </td>
                    <td>{{ strtoupper($t->metode_pembayaran ?? 'QRIS') }}</td>
                    <td>
                        <span class="st-badge st-{{ strtolower($t->status) }}">
                            {{ $t->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
            <p style="font-size: 13px; color: #94a3b8;">Menampilkan {{ $transaksi->firstItem() }}-{{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} transaksi</p>
            {{ $transaksi->links() }}
        </div>
    </div>
@endsection