@extends('layout.admin') 

@section('title', 'Verifikasi Owner - RentaCar')
@section('header_title', 'Verifikasi Owner')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/owner.css') }}">
@endpush

@section('content')
<div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); overflow: hidden;">
    <table class="owner-table">
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
            @forelse($owners as $owner)
            <tr>
                <td>
                    <div class="user-cell">
                        <div class="avatar">
                            {{ strtoupper(substr($owner->nama, 0, 2)) }}
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #1e293b;">{{ $owner->nama }}</div>
                            <div style="color: #94a3b8; font-size: 11px;">USR-{{ str_pad($owner->id_user, 5, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $owner->email }}</td>
                <td>{{ $owner->no_hp ?? '-' }}</td>
                <td>
                    <a href="#" class="btn btn-ktp">Lihat</a>
                </td>
                <td>{{ $owner->created_at->format('d M Y') }}</td>
                <td>
                    @if($owner->status_akun == 'pending')
                        <span class="status-badge status-pending">Pending</span>
                    @elseif($owner->status_akun == 'aktif')
                        <span class="status-badge status-aktif">Aktif</span>
                    @else
                        <span class="status-badge status-ditolak">Ditolak</span>
                    @endif
                </td>
                <td>
                    @if($owner->status_akun == 'pending')
                        <div class="btn-group">
                            <form action="{{ route('admin.owner.approve', $owner->id_user) }}" method="POST" onsubmit="return confirm('Approve owner ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-approve">Approve</button>
                            </form>
                            <form action="{{ route('admin.owner.reject', $owner->id_user) }}" method="POST" onsubmit="return confirm('Tolak owner ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-reject">Reject</button>
                            </form>
                        </div>
                    @else
                        <span style="color: #94a3b8; font-style: italic; font-size: 12px;">Selesai</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 3rem; color: #94a3b8;">
                    Data owner tidak ditemukan di database.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection