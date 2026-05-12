@extends('layout.admin')

@section('title', 'Verifikasi Owner')

@section('content')
<style>
    /* --- CSS KHUSUS VERIFIKASI OWNER --- */
    .verify-container { font-family: 'Inter', sans-serif; color: #1a1d2d; }

    /* Summary Text */
    .summary-text { font-size: 14px; color: #8a8d9d; margin-bottom: 25px; }

    /* Custom Tabs Button */
    .tab-group { display: flex; gap: 10px; margin-bottom: 25px; }
    .btn-tab { 
        padding: 8px 20px; border-radius: 10px; font-size: 13px; font-weight: 600;
        border: 1px solid #f1f1f1; background: #fff; color: #8a8d9d; text-decoration: none;
    }
    .btn-tab.active { background: #f59e0b; color: #fff; border-color: #f59e0b; }

    /* Search Bar */
    .search-box-wrapper {
        background: #fff; border-radius: 12px; padding: 12px 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 25px;
        display: flex; align-items: center; max-width: 400px; border: 1px solid #f1f1f1;
    }
    .search-box-wrapper i { color: #ccc; margin-right: 10px; }
    .search-box-wrapper input { border: none; outline: none; font-size: 14px; width: 100%; }

    /* Table Styling */
    .verify-card { 
        background: #fff; border-radius: 16px; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden; 
    }
    .table thead th { 
        background: #fcfcfc; padding: 15px 20px; font-size: 11px; 
        font-weight: 700; color: #adb5bd; text-transform: uppercase; border-bottom: 1px solid #f8f9fa;
    }
    .table tbody td { padding: 15px 20px; vertical-align: middle; border-bottom: 1px solid #f8f9fa; font-size: 13px; }

    /* Avatar Bulat Persis Desain */
    .avatar-init {
        width: 40px; height: 40px; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 12px; margin-right: 12px;
    }
    /* Warna random untuk avatar biar hidup */
    .bg-blue-soft { background: #eef2ff; color: #3366ff; }
    .bg-green-soft { background: #e6f4ea; color: #1e7e34; }
    .bg-orange-soft { background: #fff4e5; color: #b45d00; }
    .bg-red-soft { background: #fdeaea; color: #c62828; }
    .bg-purple-soft { background: #f3e8ff; color: #7e22ce; }

    /* Action Buttons */
    .btn-view-ktp { color: #3366ff; background: #eef2ff; border: 1px solid #e0e7ff; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; }
    .btn-approve { background: #10b981; color: #fff; border: none; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; }
    .btn-reject { background: #fff; color: #ff4d4d; border: 1px solid #fdeaea; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; }

    .badge-pending { background: #fff4e5; color: #b45d00; padding: 5px 12px; border-radius: 6px; font-weight: 600; font-size: 11px; }
</style>

<div class="verify-container">
    <h4 class="fw-bold mb-1">Verifikasi Owner</h4>
    <p class="summary-text">7 pengajuan menunggu, 124 disetujui, 8 ditolak bulan ini</p>

    <div class="tab-group">
        <a href="#" class="btn-tab active">Pending (7)</a>
        <a href="#" class="btn-tab">Disetujui</a>
        <a href="#" class="btn-tab">Ditolak</a>
    </div>

    <div class="search-box-wrapper">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Cari nama user, email, atau No HP...">
    </div>

    <div class="verify-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>KTP</th>
                        <th>Tgl Ajukan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Array Warna untuk variasi avatar --}}
                    @php $colors = ['bg-blue-soft', 'bg-green-soft', 'bg-orange-soft', 'bg-red-soft', 'bg-purple-soft']; @endphp
                    
                    @foreach($pendingOwners as $index => $owner)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-init {{ $colors[$index % 5] }}">
                                    {{ strtoupper(substr($owner->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $owner->nama }}</div>
                                    <small class="text-muted" style="font-size: 10px;">{{ $owner->id_card_number ?? '3201050590001' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-secondary">{{ $owner->email }}</td>
                        <td class="text-secondary">{{ $owner->no_hp }}</td>
                        <td>
                            <button class="btn-view-ktp">Lihat</button>
                        </td>
                        <td class="text-secondary">28 Apr 2026</td>
                        <td>
                            <span class="badge-pending">Pending</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.owner.approve', $owner->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-approve">Approve</button>
                                </form>
                                <button class="btn-reject">Reject</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-top">
            <small class="text-muted">Menampilkan {{ $pendingOwners->count() }} pengajuan pending</small>
        </div>
    </div>
</div>
@endsection