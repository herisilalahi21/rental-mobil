@extends('layout.admin')

@section('title', 'Laporan Sistem')
@section('header_title', 'Laporan Sistem')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/laporan.css') }}">
@endpush

@section('content')
    <div class="report-filter">
        <div style="display: flex; gap: 10px; align-items: center;">
            <span style="font-weight: 700; font-size: 14px;">Periode:</span>
            <button class="btn-filter">Hari ini</button>
            <button class="btn-filter">7 hari</button>
            <button class="btn-filter active">30 hari</button>
            <button class="btn-filter">1 tahun</button>
        </div>
        <div style="display: flex; gap: 10px;">
            <button class="btn btn-ktp" style="padding: 8px 15px;">PDF 📄</button>
            <button class="btn" style="background: #1e293b; color: white; padding: 8px 15px;">Excel 📊</button>
        </div>
    </div>

    <div class="report-grid">
        <div class="r-card">
            <span class="label">Total Transaksi</span>
            <span class="value">{{ number_format($totalTransaksi, 0, ',', '.') }}</span>
            <div class="growth up">▲ +12% <span style="color: #94a3b8; font-weight: 400;">vs bulan lalu</span></div>
        </div>
        <div class="r-card">
            <span class="label">Total Pendapatan</span>
            <span class="value">Rp {{ number_format($totalPendapatan / 1000000000, 2, ',', '.') }} Miliar</span>
            <div class="growth up">▲ +18% <span style="color: #94a3b8; font-weight: 400;">vs bulan lalu</span></div>
        </div>
        <div class="r-card">
            <span class="label">User Baru</span>
            <span class="value">{{ number_format($userBaru, 0, ',', '.') }}</span>
            <div class="growth up">▲ +5% <span style="color: #94a3b8; font-weight: 400;">vs bulan lalu</span></div>
        </div>
    </div>

    <div class="card" style="padding: 25px; margin-bottom: 25px; background: white; border-radius: 16px;">
        <h4 style="margin: 0 0 20px 0;">Tren Pendapatan & Transaksi</h4>
        <div style="height: 250px; display: flex; align-items: flex-end; gap: 20px; padding-bottom: 20px;">
            <canvas id="trenChart"></canvas>
        </div>
    </div>

    <div class="card" style="padding: 25px; background: white; border-radius: 16px;">
        <h4 style="margin: 0 0 20px 0;">Mobil Terlaris</h4>
        <table class="owner-table">
            <thead>
                <tr>
                    <th>RANK</th>
                    <th>MOBIL</th>
                    <th>KATEGORI</th>
                    <th>SEWA</th>
                    <th>PENDAPATAN</th>
                    <th>RATING</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mobilTerlaris as $index => $m)
                <tr>
                    <td class="rank-text">#{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $m->nama_mobil }}</strong><br>
                        <small style="color: #94a3b8;">{{ $m->plat_nomor }}</small>
                    </td>
                    <td><span class="status-badge" style="background: #f1f5f9; color: #475569;">{{ $m->kategori ?? 'MPV' }}</span></td>
                    <td><strong>{{ $m->jumlah_sewa }}</strong></td>
                    <td><strong>Rp {{ number_format($m->total_pendapatan / 1000000, 1, ',', '.') }}jt</strong></td>
                    <td class="rating-text">★ {{ number_format($m->rating ?? 4.5, 1) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Logic Chart bisa pake data dummy dulu atau ambil dari controller
    const ctx = document.getElementById('trenChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1 Apr', '8 Apr', '15 Apr', '22 Apr', '29 Apr', '6 Mei'],
            datasets: [
                { label: 'Pendapatan', data: [10, 25, 45, 30, 55, 70], borderColor: '#2563eb', tension: 0.4 },
                { label: 'Transaksi', data: [5, 15, 35, 25, 45, 60], borderColor: '#10b981', borderDash: [5, 5], tension: 0.4 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endpush