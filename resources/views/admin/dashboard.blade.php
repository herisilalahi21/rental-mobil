@extends('layout.admin')

@section('title', 'Dashboard Super Admin')
@section('header_title', 'Dashboard Super Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-box" style="background: #DBEAFE; color: #2563EB;">U</div>
            <span class="stat-label">Jumlah User</span>
            <span class="stat-value">{{ number_format($jumlahUser, 0, ',', '.') }}</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box" style="background: #FEF3C7; color: #D97706;">O</div>
            <span class="stat-label">Jumlah Owner</span>
            <span class="stat-value">{{ number_format($jumlahOwner, 0, ',', '.') }}</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box" style="background: #DCFCE7; color: #15803D;">M</div>
            <span class="stat-label">Jumlah Mobil</span>
            <span class="stat-value">{{ number_format($jumlahMobil, 0, ',', '.') }}</span>
        </div>

        <div class="stat-card dark">
            <div class="stat-icon-box" style="background: #F59E0B; color: #000;">$</div>
            <span class="stat-label">Total Pendapatan</span>
            <span class="stat-value">
                @if($totalPendapatan >= 1000000000)
                    Rp {{ number_format($totalPendapatan / 1000000000, 1, ',', '.') }} Miliar
                @else
                    Rp {{ number_format($totalPendapatan / 1000000, 1, ',', '.') }} Juta
                @endif
            </span>
        </div>
    </div>

    <div class="stat-card" style="margin-bottom: 25px; padding: 30px;">
        <div style="margin-bottom: 20px;">
            <h4 style="margin:0; font-weight: 800; color: #1E293B;">Pendapatan Platform</h4>
            <p style="font-size:12px; color:#94A3B8; margin-top: 5px;">Data 12 bulan terakhir (Tahun {{ date('Y') }})</p>
        </div>
        <div style="height: 300px;">
            <canvas id="incomeChart"></canvas>
        </div>
    </div>

    <div class="activity-container">
        <div class="activity-header">
            <h4 style="margin:0; font-weight: 800; color: #1E293B;">Aktivitas Terbaru</h4>
            <a href="#" style="font-size: 13px; color: #2563EB; font-weight: 700; text-decoration:none;">Lihat semua</a>
        </div>

        <div class="activity-list">
            {{-- Alert Pengajuan Owner Baru --}}
            @if($ownerPendingCount > 0)
            <div class="activity-item">
                <div class="icon-circle" style="background: #FEF3C7; color: #D97706;">!</div>
                <div style="flex: 1;">
                    <strong style="font-size: 14px; color: #1E293B;">{{ $ownerPendingCount }} pengajuan owner baru menunggu verifikasi</strong><br>
                    <small style="color: #94A3B8;">Membutuhkan tindakan admin</small>
                </div>
                <a href="{{ route('admin.owner') }}" class="btn-tinjau">Tinjau &rarr;</a>
            </div>
            @endif

            {{-- Looping Transaksi Terbaru --}}
            @forelse($aktivitasTerbaru as $trx)
            <div class="activity-item">
                <div class="icon-circle" style="background: #DBEAFE; color: #2563EB;">$</div>
                <div style="flex: 1;">
                    <strong style="font-size: 14px; color: #1E293B;">
                        Transaksi #TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }} {{ $trx->status }} — Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </strong><br>
                    <small style="color: #94A3B8;">
                        {{ $trx->created_at->diffForHumans() }} • Oleh {{ $trx->user->nama ?? 'User Terhapus' }}
                    </small>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 20px; color: #94A3B8;">
                Belum ada data transaksi masuk.
            </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('incomeChart').getContext('2d');
    
    // Gradient Biru untuk Chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labelBulan), // Mengambil label bulan dari Controller
            datasets: [{
                label: 'Total Pendapatan',
                data: @json($pendapatanBulanan), // Mengambil angka pendapatan dari Controller
                borderColor: '#2563EB',
                borderWidth: 4,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointRadius: 2,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#2563EB',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) { label += ': '; }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#F1F5F9', drawBorder: false },
                    ticks: { 
                        color: '#94A3B8', 
                        font: { size: 11 },
                        callback: function(value) {
                            if (value >= 1000000000) return (value / 1000000000) + ' M';
                            if (value >= 1000000) return (value / 1000000) + ' Jt';
                            return value;
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94A3B8', font: { size: 11 } }
                }
            }
        }
    });
</script>
@endpush