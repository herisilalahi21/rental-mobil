@extends('layout.admin')

@section('title', 'Kelola User')

@section('page_title', 'Kelola Data User')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/user_data.css') }}">
@endpush

@section('content')
    <section class="user-stats-grid">
        <div class="user-stat-card">
            <div class="user-stat-icon" style="background:#DBEAFE; color:#2563EB;">👤</div>
            <div>
                <span class="stat-label">TOTAL USER</span>
                <strong class="stat-value">{{ number_format($totalUser ?? 0, 0, ',', '.') }}</strong>
            </div>
        </div>
        <div class="user-stat-card">
            <div class="user-stat-icon" style="background:#DCFCE7; color:#10B981;">✅</div>
            <div>
                <span class="stat-label" style="color: #10B981;">USER AKTIF</span>
                <strong class="stat-value" style="color: #10B981;">{{ number_format($userAktif ?? 0, 0, ',', '.') }}</strong>
            </div>
        </div>
        <div class="user-stat-card">
            <div class="user-stat-icon" style="background:#FEF3C7; color:#F59E0B;">👑</div>
            <div>
                <span class="stat-label" style="color: #F59E0B;">ROLE OWNER</span>
                <strong class="stat-value" style="color: #F59E0B;">{{ number_format($roleOwner ?? 0, 0, ',', '.') }}</strong>
            </div>
        </div>
        <div class="user-stat-card">
            <div class="user-stat-icon" style="background:#FEE2E2; color:#EF4444;">🚫</div>
            <div>
                <span class="stat-label" style="color: #EF4444;">NONAKTIF</span>
                <strong class="stat-value" style="color: #EF4444;">{{ number_format($nonAktif ?? 0, 0, ',', '.') }}</strong>
            </div>
        </div>
    </section>

    <div class="table-container">
        <div class="table-header">
            <form action="{{ route('admin.users') }}" method="GET" class="filter-form">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" name="search" placeholder="Cari nama atau email..." class="search-input" value="{{ request('search') }}">
                </div>
                
                <select name="role" class="select-filter" onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                </select>

                <select name="status" class="select-filter" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="suspend" {{ request('status') == 'suspend' ? 'selected' : '' }}>Suspend</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </form>

            <a href="{{ route('admin.users.export', request()->except(['id', 'id_user'])) }}" class="btn-export">
                Export Data 📥
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="30"><input type="checkbox"></th>
                    <th>USER</th>
                    <th>EMAIL</th>
                    <th>ROLE</th>
                    <th>BERGABUNG</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        <div class="user-cell">
                            @php
                                // Generate warna avatar otomatis berdasarkan nama
                                $namaUser = $user->nama ?? 'Unknown';
                                $warna = substr(md5($namaUser), 0, 6);
                            @endphp
                            <div class="user-avatar" style="background: #{{ $warna }}20; color: #{{ $warna }};">
                                {{ strtoupper(substr($namaUser, 0, 2)) }}
                            </div>
                            <div>
                                <div class="user-name">{{ $namaUser }}</div>
                                <div class="user-id">USR-{{ str_pad($user->id_user, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="email-cell">{{ $user->email }}</td>
                    <td>
                        <span class="role-badge role-{{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="date-cell">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="badge-status {{ $user->status_akun == 'aktif' ? 'badge-aktif' : ($user->status_akun == 'suspend' ? 'badge-pending' : 'badge-nonaktif') }}">
                            {{ ucfirst($user->status_akun ?? 'aktif') }}
                        </span>
                    </td>
                    <td>
                        <div class="action-wrapper">
    {{-- Rute untuk melihat detail user --}}
    <a href="{{ route('admin.users.detail', $user->id_user) }}" class="btn-detail">
        Detail
    </a>

    {{-- Rute untuk membuka halaman form edit user --}}
    <a href="{{ route('admin.users.edit', $user->id_user) }}" class="btn-edit">
        Edit
    </a>
</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #94A3B8;">
                        Data user tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="table-footer">
            <span class="data-info">
                Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() ?? 0 }} user
            </span>
            <div class="pagination-box">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection