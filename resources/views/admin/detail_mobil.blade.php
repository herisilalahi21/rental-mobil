<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mobil - {{ $mobil->nama_mobil }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563EB;
            --danger: #EF4444;
            --bg-body: #F1F5F9;
            --text-main: #1E293B;
            --text-muted: #64748B;
            --border: #E2E8F0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            padding: 20px;
        }

        .detail-container {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header-info {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }

        /* Grid System */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .info-card {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
        }

        .info-card h3 {
            font-size: 11px;
            font-weight: 800;
            color: var(--text-muted);
            margin-top: 0;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Profile Layouts */
        .car-profile, .owner-profile {
            display: flex;
            gap: 20px;
        }

        .car-image-placeholder {
            width: 180px;
            height: 120px;
            background: #E2E8F0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: var(--text-muted);
        }

        .owner-avatar {
            width: 60px;
            height: 60px;
            background: #FEF3C7;
            color: #D97706;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 18px;
        }

        h4 { margin: 0 0 5px 0; font-size: 18px; font-weight: 700; }
        p { margin: 0; font-size: 13px; color: var(--text-muted); }

        .spec-table {
            width: 100%;
            margin-top: 15px;
            font-size: 13px;
            border-collapse: collapse;
        }

        .spec-table td { padding: 6px 0; border-bottom: 1px dashed #F1F5F9; }
        .spec-table td:last-child { text-align: right; }

        /* Status Banner */
        .status-banner {
            background: #F8FAFC;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .status-now { display: flex; align-items: center; gap: 15px; }
        .icon-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        /* Dynamic Colors for Status */
        .disewa { background: #DBEAFE; color: #2563EB; }
        .tersedia { background: #DCFCE7; color: #15803D; }

        .status-details { display: flex; gap: 40px; }
        .status-details small { display: block; font-size: 10px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; }
        .status-details p { color: var(--text-main); font-weight: 700; font-size: 14px; margin-top: 2px; }

        /* Footer Buttons */
        .action-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn {
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: 0.2s;
            border: none;
            font-family: inherit;
        }

        .btn-back { background: white; border: 1px solid var(--border); color: var(--text-main); }
        .btn-danger { background: white; border: 1px solid var(--danger); color: var(--danger); }
        .btn-secondary { background: #F8FAFC; border: 1px solid var(--border); color: var(--text-main); }
        .btn-primary { background: var(--primary); color: white; }

        .btn:hover { opacity: 0.8; transform: translateY(-1px); }

        .verify-badge {
            display: inline-block;
            background: #DCFCE7;
            color: #15803D;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 700;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="detail-container">
    <div class="header-info">
        <span>ID Mobil: <strong>CAR-{{ $mobil->id_mobil }}</strong> • Terdaftar {{ $mobil->created_at->format('d M Y') }}</span>
    </div>

    <div class="main-grid">
        <div class="info-card">
            <h3>🚗 INFORMASI MOBIL</h3>
            <div class="car-profile">
                <div class="car-image-placeholder">🖼️ 1/5</div>
                <div class="car-specs">
                    <h4>{{ $mobil->nama_mobil }}</h4>
                    <p>{{ $mobil->deskripsi_singkat ?? 'Sedan keluarga premium' }}</p>
                    <table class="spec-table">
                        <tr><td>Kategori</td><td><strong>{{ $mobil->kategori }}</strong></td></tr>
                        <tr><td>Tahun</td><td><strong>{{ $mobil->tahun }}</strong></td></tr>
                        <tr><td>Plat Nomor</td><td><strong>{{ $mobil->plat_nomor }}</strong></td></tr>
                        <tr><td>Transmisi</td><td><strong>{{ $mobil->transmisi }}</strong></td></tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="info-card">
            <h3>👤 INFORMASI OWNER</h3>
            <div class="owner-profile">
                <div class="owner-avatar">{{ substr($mobil->owner->nama, 0, 2) }}</div>
                <div class="owner-details">
                    <h4>{{ $mobil->owner->nama }}</h4>
                    <span class="verify-badge">✓ Terverifikasi</span>
                    <p>⭐ {{ $mobil->owner->rating ?? '4.9' }} / 5.0</p>
                    <p>📞 {{ $mobil->owner->kontak ?? '+62 812-3456-7890' }}</p>
                    <p>📍 {{ $mobil->owner->lokasi ?? 'Jakarta Selatan' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="status-banner">
        <div class="status-now">
            <div class="icon-circle {{ strtolower($mobil->status) }}">🚗</div>
            <div>
                <small>Status Sekarang</small>
                <h4>{{ strtoupper($mobil->status) }}</h4>
            </div>
        </div>

        @if($mobil->status == 'disewa')
        <div class="status-details">
            <div><small>Penyewa Aktif</small><p>Andika Saputra</p></div>
            <div><small>Berakhir</small><p>18 Mei 2026, 10:00</p></div>
            <div><small>Diupdate</small><p>{{ $mobil->updated_at->diffForHumans() }}</p></div>
        </div>
        @else
        <div class="status-details">
            <p style="color: #15803D;">✓ Mobil siap untuk disewakan kepada pelanggan.</p>
        </div>
        @endif
    </div>

    <div class="action-footer">
        <a href="{{ route('admin.mobil') }}" class="btn btn-back">Tutup</a>
        <button class="btn btn-danger">⚠️ Nonaktifkan Mobil</button>
        <button class="btn btn-secondary">📄 Export PDF</button>
        <button class="btn btn-primary">💾 Update Status</button>
    </div>
</div>

</body>
</html>