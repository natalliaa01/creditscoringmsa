<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Register</title>
    
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
                <img src="{{ asset('img/shaka_utama.png') }}" alt="Register Illustration">
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="auth-form">
            <!-- Brand -->
            <div class="auth-brand">
                <div class="auth-brand-icon">
                    <img src="{{ asset('img/msa.png') }}" alt="Logo BPR MSA">
                </div>
                <div class="auth-brand-name">Credit Scoring PT BPR MSA</div>
            </div>

            <h1 class="auth-form-title">Bergabung dengan kami</h1>
            <p class="auth-form-subtitle">Buat akun baru untuk memulai perjalanan Anda</p>

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                
                <!-- Name -->
                <div class="auth-form-group">
                    <label for="name" class="auth-form-label">Nama Lengkap</label>
                    <input 
                        id="name" 
                        class="auth-form-control @error('name') is-invalid @enderror" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        autocomplete="name"
                        placeholder="Masukkan nama lengkap Anda"
                    >
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

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
                        autocomplete="username"
                        placeholder="Masukkan alamat email Anda"
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
                        class="auth-form-control has-toggle @error('password') is-invalid @enderror" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="Buat password yang kuat"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password')" aria-label="Toggle password visibility">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="auth-form-group">
                    <label for="password_confirmation" class="auth-form-label">Konfirmasi Password</label>
                    <input 
                        id="password_confirmation" 
                        class="auth-form-control has-toggle @error('password_confirmation') is-invalid @enderror" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="Ulangi password Anda"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')" aria-label="Toggle password confirmation visibility">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Terms and Privacy Policy -->
                <div class="auth-form-check">
                    <input type="checkbox" name="terms" id="terms" required class="auth-form-check-input">
                    <label class="auth-form-check-label" for="terms">
                        Saya menyetujui <a href="#" target="_blank">Syarat & Ketentuan</a> dan <a href="#" target="_blank">Kebijakan Privasi</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="auth-btn-primary" id="registerBtn">
                    Buat Akun
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
                            Daftar dengan Google
                        </a>
                    </div>
                </div>

                <!-- Terms -->
                <div class="auth-terms-text">
                    Dengan mendaftar, Anda menyetujui <a href="#" target="_blank">Syarat & Ketentuan</a> dan <a href="#" target="_blank">Kebijakan Privasi</a> kami
                </div>

                <!-- Login Link -->
                <div class="auth-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password toggle functionality
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const toggle = field.nextElementSibling;
            const svg = toggle.querySelector('svg');
            
            if (field.type === 'password') {
                field.type = 'text';
                svg.innerHTML = `
                    <path d="17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                `;
            } else {
                field.type = 'password';
                svg.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                `;
            }
        }

        // Add loading state to register button
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('registerBtn');
            btn.classList.add('loading');
            btn.textContent = 'Membuat akun...';
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

        // Password strength indicator
        const passwordField = document.getElementById('password');
        passwordField.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            // You can add visual feedback here
        });

        function calculatePasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            return strength;
        }
    </script>
</body>
</html>
