@extends('owner.layouts.tampilan')

@section('content')
<div class="container" style="padding: 2rem 5%;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-weight: 700;">Tambah Kelola Armada</h2>
        <a href="{{ route('owner.dashboard') }}" style="text-decoration: none; color: #64748B;">✖</a>
    </div>

    {{-- 🔥 TAMBAHAN: Munculin pesan error kalau validasi gagal (misal: Plat Nomor sudah ada) --}}
    @if ($errors->any())
        <div style="background: #FEE2E2; color: #B91C1C; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid #FECACA;">
            <ul style="margin: 0; padding-left: 1.2rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('owner.mobil.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="background: white; padding: 2rem; border-radius: 16px; border: 1px solid #E2E8F0; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            {{-- Nama Mobil --}}
            <div class="form-group">
                <label style="display:block; font-size: 0.8rem; font-weight: 600; margin-bottom: 8px;">Nama Mobil</label>
                <input type="text" name="nama_mobil" value="{{ old('nama_mobil') }}" placeholder="Toyota Innova Reborn" style="width:100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px;" required>
            </div>

            {{-- Plat Nomor --}}
            <div class="form-group">
                <label style="display:block; font-size: 0.8rem; font-weight: 600; margin-bottom: 8px;">Plat Nomor</label>
                <input type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" placeholder="B 1234 ABC" style="width:100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px;" required>
            </div>

            {{-- Kategori --}}
            <div class="form-group">
                <label style="display:block; font-size: 0.8rem; font-weight: 600; margin-bottom: 8px;">Kategori</label>
                <select name="kategori" style="width:100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px;">
                    <option value="MPV" {{ old('kategori') == 'MPV' ? 'selected' : '' }}>MPV</option>
                    <option value="SUV" {{ old('kategori') == 'SUV' ? 'selected' : '' }}>SUV</option>
                    <option value="Sedan" {{ old('kategori') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                </select>
            </div>

            {{-- Transmisi & Tahun --}}
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div>
                    <label style="display:block; font-size: 0.8rem; font-weight: 600; margin-bottom: 8px;">Transmisi</label>
                    <select name="transmisi" style="width:100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px;">
                        <option value="Manual" {{ old('transmisi') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option value="Matic" {{ old('transmisi') == 'Matic' ? 'selected' : '' }}>Matic</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size: 0.8rem; font-weight: 600; margin-bottom: 8px;">Tahun</label>
                    <input type="number" name="tahun" value="{{ old('tahun') }}" placeholder="2024" style="width:100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px;" required>
                </div>
            </div>

            {{-- Harga per Hari --}}
            <div class="form-group" style="grid-column: span 2;">
                <label style="display:block; font-size: 0.8rem; font-weight: 600; margin-bottom: 8px;">Harga per Hari</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 10px; top: 10px; color: #94A3B8;">Rp</span>
                    <input type="number" name="harga_per_hari" value="{{ old('harga_per_hari') }}" placeholder="650000" style="width:100%; padding: 10px 10px 10px 35px; border: 1px solid #E2E8F0; border-radius: 8px;" required>
                </div>
            </div>

            {{-- Upload Foto --}}
            <div class="form-group" style="grid-column: span 2;">
                <label style="display:block; font-size: 0.8rem; font-weight: 600; margin-bottom: 8px;">Foto Mobil</label>
                <div style="border: 2px dashed #E2E8F0; padding: 20px; border-radius: 12px; text-align: center; background: #F8FAFC;">
                    <input type="file" name="foto" id="foto" accept="image/*" style="display: none;" onchange="previewImage(event)">
                    <label for="foto" style="cursor: pointer;">
                        <div id="preview-placeholder">
                            <span style="font-size: 2rem; color: #94A3B8; display: block; margin-bottom: 10px;">📷</span>
                            <span style="color: #64748B; font-size: 0.9rem;">Upload foto mobil</span>
                        </div>
                        <img id="img-preview" style="max-height: 200px; display: none; margin: 0 auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    </label>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="form-group" style="grid-column: span 2;">
                <label style="display:block; font-size: 0.8rem; font-weight: 600; margin-bottom: 8px;">Deskripsi</label>
                <textarea name="deskripsi" rows="3" style="width:100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px;" placeholder="Jelaskan kondisi mobil secara singkat...">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- Fitur --}}
            <div class="form-group" style="grid-column: span 2;">
                <label style="display:block; font-size: 0.8rem; font-weight: 600; margin-bottom: 15px;">Fitur Mobil</label>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    @php $fiturs = ['AC', 'Audio', 'Bluetooth', 'Airbag', 'Sensor Parkir']; @endphp
                    @foreach($fiturs as $f)
                        <label>
                            <input type="checkbox" name="fitur[]" value="{{ $f }}" {{ is_array(old('fitur')) && in_array($f, old('fitur')) ? 'checked' : '' }}> {{ $f }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div style="grid-column: span 2; display: flex; justify-content: space-between; margin-top: 20px;">
                <button type="button" onclick="history.back()" style="padding: 10px 30px; border: 1px solid #E2E8F0; background: white; border-radius: 8px; cursor: pointer;">Batal</button>
                <button type="submit" style="padding: 10px 30px; background: #2563EB; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">🚀 Simpan Armada</button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('img-preview');
            const placeholder = document.getElementById('preview-placeholder');
            output.src = reader.result;
            output.style.display = 'block';
            placeholder.style.display = 'none';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection