<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/auth-pages.css') }}" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-container">
        <!-- Left Side - Illustration -->
        <div class="auth-illustration">
            <div class="illustration-content">
                <img src="{{ asset('img/shaka_utama.png') }}" alt="Login Illustration">
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="auth-form">
            <!-- Brand -->
            <div class="auth-brand">
                <div class="auth-brand-icon">
                    <img src="{{ asset('img/msa.png') }}" alt="Logo BPR MSA">
                </div>
                <div class="auth-brand-name">Credit Scoring PT BPR MSA</div>
            </div>

            <h1 class="auth-form-title">Selamat datang kembali</h1>
            <p class="auth-form-subtitle">Masuk ke akun Anda untuk melanjutkan</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="auth-alert auth-alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                
                <!-- Email Address -->
                <div class="auth-form-group">
                    <label for="email" class="auth-form-label">Email</label>
                    <input 
                        id="email" 
                        class="auth-form-control @error('email') is-invalid @enderror" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        placeholder="Masukkan email Anda"
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="auth-form-group">
                    <label for="password" class="auth-form-label">Password</label>
                    <input 
                        id="password" 
                        class="auth-form-control @error('password') is-invalid @enderror" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="Masukkan password Anda"
                    >
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="auth-form-check">
                    <input id="remember_me" type="checkbox" class="auth-form-check-input" name="remember">
                    <label class="auth-form-check-label" for="remember_me">
                        Ingat saya selama 30 hari
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="auth-btn-primary" id="loginBtn">
                    Masuk ke Akun
                </button>

                <!-- Divider -->
                <div class="divider">atau</div>

                <!-- Social Login -->
                <div class="social-login">
                    <div class="social-buttons">
                        <a href="{{ route('auth.google') }}" class="social-btn">
                            <svg class="google-icon" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Masuk dengan Google
                        </a>
                    </div>
                </div>

                <!-- Terms -->
                <div class="auth-terms-text">
                    Dengan masuk, Anda menyetujui <a href="#" target="_blank">Syarat & Ketentuan</a> dan <a href="#" target="_blank">Kebijakan Privasi</a> kami
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <div class="forgot-password-link">
                        <a href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    </div>
                @endif

                <!-- Register Link -->
                <div class="auth-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Add loading state to login button
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.textContent = 'Sedang masuk...';
        });

        // Add focus animations
        document.querySelectorAll('.auth-form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>
</html>
