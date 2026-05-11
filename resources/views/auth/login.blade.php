<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RentaCar</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-wrapper">
        <div class="side-info">
            <div class="brand">
                <div class="logo-box">R</div>
                <span class="brand-name">RentaCar</span>
            </div>
            
            <div class="hero-text">
                <h1>Sewa mobil,<br>jelajahi tanpa batas.</h1>
                <p>Marketplace rental mobil terpercaya untuk perjalanan Anda.</p>
            </div>

            <ul class="feature-list">
                <li><span class="dot green"></span> Ribuan mobil dari owner terverifikasi</li>
                <li><span class="dot green"></span> Booking & pembayaran aman dalam hitungan menit</li>
                <li><span class="dot green"></span> Dukungan untuk User, Owner, dan Admin</li>
            </ul>
        </div>

        <div class="side-form">
            <div class="login-card">
                <header>
                    <span class="subtitle">SELAMAT DATANG</span>
                    <h2>Masuk ke Akun</h2>
                </header>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" placeholder="••••••••" required>
                            <button type="button" class="toggle-pass">👁️</button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember"> Ingat saya
                        </label>
                        <a href="#" class="forgot-pw">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn-login">Login</button>
                </form>

                <p class="register-text">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>