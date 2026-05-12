@extends('owner.layouts.tampilan')

@section('content')
<div class="container" style="padding: 2rem 5%; font-family: 'Poppins', sans-serif; background-color: #F8FAFC; min-height: 100vh;">
    
    {{-- Header Section --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
        <div>
            <h2 style="font-weight: 700; font-size: 1.75rem; color: #1E293B; margin-bottom: 0.25rem;">Daftar Mobil</h2>
            <p style="color: #64748B; font-size: 0.95rem;">Temukan dan pantau semua mobil yang tersedia di marketplace.</p>
        </div>
        <a href="{{ route('owner.mobil.create') }}" style="padding: 12px 24px; background: #2563EB; color: white; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">
            + Tambah Mobil
        </a>
    </div>

    {{-- Statistik Cards --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 2.5rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 20px; border: 1px solid #E2E8F0; position: relative; overflow: hidden;">
            <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: #2563EB;"></div>
            <p style="font-size: 0.8rem; color: #64748B; font-weight: 500; margin-bottom: 0.5rem;">Total Mobil</p>
            <h3 style="font-size: 1.8rem; font-weight: 700; color: #1E293B; margin: 0;">{{ $daftarMobil->count() }}</h3>
        </div>
        <div style="background: white; padding: 1.5rem; border-radius: 20px; border: 1px solid #E2E8F0; position: relative; overflow: hidden;">
            <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: #22C55E;"></div>
            <p style="font-size: 0.8rem; color: #64748B; font-weight: 500; margin-bottom: 0.5rem;">Mobil Tersedia</p>
            <h3 style="font-size: 1.8rem; font-weight: 700; color: #22C55E; margin: 0;">{{ $daftarMobil->where('status', 'tersedia')->count() }}</h3>
        </div>
        <div style="background: white; padding: 1.5rem; border-radius: 20px; border: 1px solid #E2E8F0; position: relative; overflow: hidden;">
            <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: #F59E0B;"></div>
            <p style="font-size: 0.8rem; color: #64748B; font-weight: 500; margin-bottom: 0.5rem;">Sedang Disewa</p>
            <h3 style="font-size: 1.8rem; font-weight: 700; color: #F59E0B; margin: 0;">{{ $daftarMobil->where('status', 'disewa')->count() }}</h3>
        </div>
        <div style="background: white; padding: 1.5rem; border-radius: 20px; border: 1px solid #E2E8F0; position: relative; overflow: hidden;">
            <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: #94A3B8;"></div>
            <p style="font-size: 0.8rem; color: #64748B; font-weight: 500; margin-bottom: 0.5rem;">Maintenance</p>
            <h3 style="font-size: 1.8rem; font-weight: 700; color: #1E293B; margin: 0;">0</h3>
        </div>
    </div>

    {{-- Filter & Tabs --}}
    <div style="display: flex; justify-content: flex-start; gap: 12px; margin-bottom: 2.5rem; align-items: center; flex-wrap: wrap;">
        <button onclick="filterStatus('all')" class="status-btn" id="btn-all" style="padding: 10px 24px; border-radius: 12px; border: none; background: #2563EB; color: white; font-weight: 600; cursor: pointer;">Semua</button>
        <button onclick="filterStatus('tersedia')" class="status-btn" id="btn-tersedia" style="padding: 10px 24px; border-radius: 12px; border: 1px solid #E2E8F0; background: white; color: #64748B; font-weight: 500; cursor: pointer;">Tersedia</button>
        <button onclick="filterStatus('disewa')" class="status-btn" id="btn-disewa" style="padding: 10px 24px; border-radius: 12px; border: 1px solid #E2E8F0; background: white; color: #64748B; font-weight: 500; cursor: pointer;">Disewa</button>
        
        <div style="height: 24px; width: 1px; background: #E2E8F0; margin: 0 8px;"></div>
        
        <select id="selectKategori" onchange="applyAllFilters()" style="padding: 10px 16px; border-radius: 12px; border: 1px solid #E2E8F0; background: white; color: #64748B; cursor: pointer; outline: none;">
            <option value="all">Semua Kategori</option>
            @foreach($daftarMobil->pluck('kategori')->unique() as $kat)
                <option value="{{ $kat }}">{{ $kat }}</option>
            @endforeach
        </select>
    </div>

    {{-- Grid Mobil --}}
    <div id="mobilGrid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px;">
        @forelse($daftarMobil as $mobil)
            <div class="mobil-card" 
                 data-status="{{ $mobil->status }}" 
                 data-kategori="{{ $mobil->kategori }}" 
                 data-harga="{{ $mobil->harga_per_hari }}"
                 style="background: white; border-radius: 24px; border: 1px solid #E2E8F0; padding: 0; overflow: hidden; position: relative; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: 0.3s;">
                
                {{-- Badge Status --}}
                @php
                    $statusColor = $mobil->status == 'tersedia' ? '#22C55E' : ($mobil->status == 'disewa' ? '#EF4444' : '#F59E0B');
                    $bgColor = $mobil->status == 'tersedia' ? '#DCFCE7' : ($mobil->status == 'disewa' ? '#FEE2E2' : '#FEF3C7');
                @endphp
                <span style="position: absolute; top: 20px; right: 20px; background: {{ $bgColor }}; color: {{ $statusColor }}; padding: 6px 14px; border-radius: 100px; font-size: 0.7rem; font-weight: 700; z-index: 1; text-transform: uppercase;">
                    {{ $mobil->status }}
                </span>

                {{-- Image Box --}}
                <div style="padding: 24px 24px 0 24px; text-align: center; background: #fdfdfd;">
                    @if($mobil->foto)
                        <img src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama_mobil }}" style="width: 100%; height: 160px; object-fit: contain;">
                    @else
                        <div style="width: 100%; height: 160px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; border-radius: 12px; color: #94A3B8;">No Image</div>
                    @endif
                </div>

                {{-- Info Box --}}
                <div style="padding: 24px;">
                    <h4 style="font-size: 1.15rem; font-weight: 700; color: #1E293B; margin-bottom: 0.4rem;">{{ $mobil->nama_mobil }}</h4>
                    <p style="font-size: 0.8rem; color: #94A3B8; margin-bottom: 1.25rem;">{{ $mobil->kategori }} • {{ $mobil->transmisi }} • {{ $mobil->tahun }}</p>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #F1F5F9; padding-top: 1.25rem;">
                        <div>
                            <span style="font-size: 1.25rem; font-weight: 800; color: #2563EB;">Rp {{ number_format($mobil->harga_per_hari/1000, 0) }}rb</span>
                            <span style="font-size: 0.75rem; color: #94A3B8;">/hari</span>
                        </div>
                    </div>

                    {{-- PERBAIKAN: Route ganti ke owner.mobil.show --}}
                    <a href="{{ route('owner.mobil.show', $mobil->id) }}" 
                       style="margin-top: 1.5rem; display: flex; justify-content: center; align-items: center; width: 100%; padding: 12px; background: #0F172A; color: white; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.2s;" 
                       onmouseover="this.style.background='#1E293B'" 
                       onmouseout="this.style.background='#0F172A'">
                        Detail <span style="margin-left: 8px;">→</span>
                    </a>
                </div>
            </div>
        @empty
            <div style="grid-column: span 4; text-align: center; padding: 5rem 0; background: white; border-radius: 24px; border: 1px dashed #CBD5E1;">
                <p style="color: #94A3B8; font-weight: 500; margin-bottom: 1rem;">Belum ada armada yang ditambahkan.</p>
                <a href="{{ route('owner.mobil.create') }}" style="color: #2563EB; font-weight: 700; text-decoration: none;">+ Tambah Mobil Pertama Lo</a>
            </div>
        @endforelse
    </div>
</div>

<script>
    let filterState = {
        status: 'all',
    };

    function filterStatus(status) {
        filterState.status = status;
        document.querySelectorAll('.status-btn').forEach(btn => {
            btn.style.background = 'white';
            btn.style.color = '#64748B';
            btn.style.border = '1px solid #E2E8F0';
        });

        const activeBtn = document.getElementById('btn-' + status);
        activeBtn.style.background = '#2563EB';
        activeBtn.style.color = 'white';
        activeBtn.style.border = 'none';

        applyAllFilters();
    }

    function applyAllFilters() {
        const selectedKat = document.getElementById('selectKategori').value;
        const cards = document.querySelectorAll('.mobil-card');

        cards.forEach(card => {
            const statusCard = card.getAttribute('data-status');
            const katCard = card.getAttribute('data-kategori');

            const matchStatus = (filterState.status === 'all' || statusCard === filterState.status);
            const matchKat = (selectedKat === 'all' || katCard === selectedKat);

            if (matchStatus && matchKat) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endsection