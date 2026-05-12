@extends('owner.layouts.tampilan')

@section('content')
<div class="container" style="padding: 2rem 5%; font-family: 'Poppins', sans-serif; background-color: #F8FAFC; min-height: 100vh;">
    
    {{-- Header --}}
    <div style="margin-bottom: 2rem;">
        <h2 style="font-weight: 700; color: #1E293B;">Detail Mobil</h2>
        <p style="color: #64748B;">Kelola foto unit armada lo dengan mudah.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
        
        {{-- Sisi Kiri: Visual & Galeri --}}
        <div>
            {{-- Wadah Gambar Utama --}}
            <div style="background: #E0FDFB; border-radius: 24px; padding: 40px; text-align: center; position: relative; height: 400px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #E2E8F0; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
                <span style="position: absolute; top: 20px; left: 20px; background: white; color: {{ $mobil->status == 'tersedia' ? '#22C55E' : '#EF4444' }}; padding: 6px 16px; border-radius: 100px; font-weight: 700; font-size: 0.8rem; text-transform: capitalize; z-index: 5; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    ● {{ $mobil->status }}
                </span>
                
                <img id="mainImage" src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama_mobil }}" style="width: 100%; height: 100%; object-fit: contain; transition: 0.3s ease-in-out;">
            </div>

            {{-- Grid Galeri --}}
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-top: 20px;">
                
                {{-- 1. Thumbnail Foto Utama --}}
                <div onclick="changePhoto('{{ asset('storage/' . $mobil->foto) }}', this)" 
                     style="aspect-ratio: 1/1; background: white; border: 2px solid #2563EB; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; overflow: hidden; padding: 4px;"
                     class="thumb-item active-thumb">
                    <img src="{{ asset('storage/' . $mobil->foto) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                </div>

                {{-- 2. Foto Galeri (Looping) --}}
                @if($mobil->galeri)
                    @foreach($mobil->galeri as $g)
                    <div onclick="changePhoto('{{ asset('storage/' . $g->foto) }}', this)" 
                         style="aspect-ratio: 1/1; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; overflow: hidden; border: 1px solid #E2E8F0; padding: 4px;"
                         class="thumb-item">
                        <img src="{{ asset('storage/' . $g->foto) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                    </div>
                    @endforeach
                @endif

                {{-- 3. Tombol Tambah Foto Otomatis --}}
                <div onclick="document.getElementById('fileInput').click();" 
                     style="aspect-ratio: 1/1; background: #FEF2F2; border-radius: 12px; border: 1px dashed #EF4444; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; text-align: center; padding: 5px;">
                    
                    <span style="color: #EF4444; font-weight: 800; font-size: 0.7rem; line-height: 1.2;">+ TAMBAH<br>FOTO</span>
                    
                    <form id="autoUploadForm" action="{{ route('owner.mobil.updateFoto', $mobil->id) }}" method="POST" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        @method('PUT')
                        <input type="file" id="fileInput" name="foto_baru" accept="image/*" onchange="document.getElementById('autoUploadForm').submit();">
                    </form>
                </div>

            </div>
        </div>

        {{-- Sisi Kanan: Info Unit --}}
        <div style="padding-top: 10px;">
            <h1 style="font-size: 2.2rem; font-weight: 800; color: #1E293B; margin-bottom: 5px; text-transform: uppercase;">{{ $mobil->nama_mobil }}</h1>
            <p style="color: #64748B; font-size: 1.1rem; margin-bottom: 25px;">{{ $mobil->kategori }} • {{ $mobil->transmisi }} • {{ $mobil->tahun }}</p>
            
            <h2 style="font-size: 2.8rem; font-weight: 800; color: #2563EB; margin-bottom: 35px;">
                Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}<span style="font-size: 1rem; color: #94A3B8; font-weight: 400;">/hari</span>
            </h2>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px; background: white; padding: 25px; border-radius: 20px; border: 1px solid #F1F5F9;">
                <div>
                    <p style="margin: 0; color: #94A3B8; font-size: 0.85rem;">Plat Nomor</p>
                    <p style="font-weight: 700; color: #1E293B;">{{ $mobil->plat_nomor }}</p>
                </div>
                <div>
                    <p style="margin: 0; color: #94A3B8; font-size: 0.85rem;">Lokasi</p>
                    <p style="font-weight: 700; color: #1E293B;">Siborong-borong</p>
                </div>
            </div>

            <div style="display: flex; gap: 15px;">
                <a href="{{ route('owner.mobil.edit', $mobil->id) }}" style="flex: 1; text-align: center; text-decoration: none; padding: 18px; border-radius: 16px; background: #0F172A; color: white; font-weight: 600; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.3);">✍ Edit Data</a>
                <button style="flex: 1; padding: 18px; border-radius: 16px; border: 1px solid #E2E8F0; background: white; color: #1E293B; font-weight: 600; cursor: pointer;">📋 Riwayat</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk ganti preview foto utama
    function changePhoto(url, element) {
        if (!url) return;
        const mainImg = document.getElementById('mainImage');
        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = url;
            mainImg.style.opacity = '1';
        }, 200);

        // Reset border semua thumb
        document.querySelectorAll('.thumb-item').forEach(thumb => {
            thumb.style.border = '1px solid #E2E8F0';
        });
        // Aktifkan border yang diklik
        element.style.border = '2px solid #2563EB';
    }
</script>
@endsection