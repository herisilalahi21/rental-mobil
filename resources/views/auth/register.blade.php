<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - RentaCar</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>

    <header class="navbar">
        <div class="container navbar-flex">
            <div class="brand">
                <div class="logo-box">R</div>
                <span class="brand-name">RentaCar</span>
            </div>
            <div class="nav-right">
                <span>Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="btn-login-nav">Login</a>
            </div>
        </div>
    </header>

    <main class="container main-content">
        <div class="header-text">
            <h1>Buat Akun Baru</h1>
            <p>Pilih jenis akun yang ingin Anda daftarkan.</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <strong>Waduh, ada yang salah nih:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="tab-container">
            <button class="tab-btn {{ old('role') !== 'owner' ? 'active' : '' }}" onclick="switchTab(event, 'user-section')">Sebagai User</button>
            <button class="tab-btn {{ old('role') === 'owner' ? 'active' : '' }}" onclick="switchTab(event, 'owner-section')">Sebagai Owner</button>
        </div>

        <div class="form-wrapper">
            <div id="user-section" class="tab-content {{ old('role') !== 'owner' ? 'active' : '' }}">
                <div class="card">
                    <div class="card-header">
                        <h2>Register sebagai User</h2>
                        <p>Cepat & gratis. Mulai sewa mobil dalam beberapa menit.</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="customer">

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@gmail.com" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••" required>
                        </div>

                        <div class="terms-group">
                            <input type="checkbox" id="terms-user" name="terms" required>
                            <label for="terms-user">Saya menyetujui <a href="#">Syarat & Ketentuan</a></label>
                        </div>

                        <button type="submit" class="btn-blue">Daftar Sekarang</button>
                    </form>
                    <p class="card-footer">Akun User dapat menyewa mobil dari owner manapun.</p>
                </div>
            </div>

            <div id="owner-section" class="tab-content {{ old('role') === 'owner' ? 'active' : '' }}">
                <div class="card">
                    <div class="card-header">
                        <span class="badge-admin">VERIFIKASI ADMIN</span>
                        <h2>Register sebagai Owner</h2>
                        <p>Daftarkan armada Anda. Status awal: pending verifikasi.</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="role" value="owner">

                        <div class="form-grid-row">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                            </div>
                        </div>

                        <div class="form-grid-row">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="••••••••" required>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="form-grid-row">
                            <div class="form-group">
                                <label>No HP</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="0812..." required>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Alamat lengkap" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Upload Identitas (KTP)</label>
                            <div class="upload-area" onclick="document.getElementById('ktp_file').click()">
                                <input type="file" name="ktp_file" id="ktp_file" hidden onchange="showFileName(this)">
                                <div class="upload-icon">↑</div>
                                <p id="upload-text">Klik untuk upload KTP / drag & drop</p>
                                <span>JPG, PNG, PDF — maks. 2MB</span>
                            </div>
                        </div>

                        <div class="alert-pending">
                            <div class="alert-icon">!</div>
                            <div class="alert-text">
                                <strong>Status owner: pending</strong>
                                <p>Akun Anda akan aktif sebagai owner setelah disetujui admin.</p>
                            </div>
                        </div>

                        <button type="submit" class="btn-dark">Ajukan Pendaftaran Owner</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        function switchTab(evt, tabName) {
            let i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
        }

        function showFileName(input) {
            let fileName = input.files[0].name;
            document.getElementById('upload-text').innerText = "File terpilih: " + fileName;
            document.getElementById('upload-text').style.color = "#2563EB";
        }
    </script>
</body>
</html>