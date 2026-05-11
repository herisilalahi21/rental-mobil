<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User - {{ $user->nama }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/user_detail.css') }}">
</head>
<body>

<div class="main-container">
    <div class="modal-card">
        <header class="header">
            <div>
                <h2 class="header-title">Detail Informasi User</h2>
                <p class="header-subtitle">
                    {{-- FIX: Pakai id_user --}}
                    ID User: <span class="id-highlight">USR-{{ str_pad($user->id_user, 5, '0', STR_PAD_LEFT) }}</span> 
                    • Terdaftar {{ $user->created_at->format('d M Y') }}
                </p>
            </div>
            <a href="{{ route('admin.users') }}" class="back-btn">&times;</a>
        </header>

        <div class="content-body">
            <div class="grid-layout">
                <div class="card-box">
                    <span class="card-label">👤 INFORMASI PROFIL</span>
                    <div class="profile-section">
                        @php
                            $inisial = strtoupper(substr($user->nama ?? 'U', 0, 1));
                            $warna = substr(md5($user->nama), 0, 6);
                        @endphp
                        <div class="profile-avatar" style="background: #{{ $warna }}20; color: #{{ $warna }};">
                            {{ $inisial }}
                        </div>
                        <div class="user-info">
                            <h3 class="user-name">{{ $user->nama }}</h3>
                            <p class="user-mail">{{ $user->email }}</p>
                            <span class="role-badge">{{ ucfirst($user->role ?? 'User') }}</span>
                        </div>
                    </div>
                    <div class="contact-list">
                        {{-- FIX: Sesuai field fillable di Model lo (no_hp) --}}
                        <p>📞 {{ $user->no_hp ?? 'Tidak ada nomor telp' }}</p>
                        <p>📍 {{ $user->alamat ?? 'Alamat belum diatur' }}</p>
                        <p>📅 Member Sejak: {{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="card-box">
                    <span class="card-label">📊 STATISTIK AKTIVITAS</span>
                    <div class="stats-wrapper">
                        <div class="stat-box">
                            <p style="font-size: 11px; color: #64748b; margin:0;">Total Transaksi</p>
                            <p class="stat-num">{{ $user->transaksi_count ?? 0 }}</p>
                        </div>
                        <div class="stat-box">
                            <p style="font-size: 11px; color: #64748b; margin:0;">Total Unit Mobil</p>
                            {{-- FIX: Pakai mobils_count (sesuai relasi hasMany 'mobils' di Model) --}}
                            <p class="stat-num">{{ $user->mobils_count ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="footer-text">
                        <p>Status Akun Saat Ini: 
                            <span class="dot {{ $user->status_akun == 'aktif' ? 'online' : 'offline' }}">
                                ● {{ ucfirst($user->status_akun) }}
                            </span>
                        </p>
                        <p>Pembaruan Terakhir: {{ $user->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- FIX: Form action pakai id_user --}}
            <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="status-section">
                    <span class="card-label">⚙️ PENGATURAN STATUS AKUN</span>
                    <div class="status-container">
                        <div class="options-group">
                            @foreach(['aktif' => '🔵', 'suspend' => '🔴', 'nonaktif' => '⚪'] as $val => $icon)
                                <label class="btn-check {{ $user->status_akun == $val ? 'active' : '' }}">
                                    <input type="radio" name="status_akun" value="{{ $val }}" 
                                           {{ $user->status_akun == $val ? 'checked' : '' }} 
                                           onchange="updateUI(this)">
                                    <span>{{ $icon }}</span> {{ ucfirst($val) }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="footer-actions">
                    <a href="{{ route('admin.users') }}" class="cancel-btn">Kembali</a>
                    <button type="submit" class="save-btn">💾 Simpan Perubahan Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateUI(input) {
        const labels = input.closest('.options-group').querySelectorAll('.btn-check');
        labels.forEach(l => l.classList.remove('active'));
        if (input.checked) {
            input.parentElement.classList.add('active');
        }
    }
</script>

</body>
</html>