<x-guest-layout>
    
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 200px;
        }

        .login-container {
            display: flex;
            max-width: 28000px;
            width: 100%;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            min-height: 400px;
        }

        .login-illustration {
            flex: 1;
            background: linear-gradient(135deg, #87CEEB 0%, #5DADE2 100%);
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .illustration-content {
            text-align: center;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-form {
            flex: 0.8;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        .brand {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            margin-right: 12px;
            border-radius: 4px;
            overflow: hidden;
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .form-title {
            font-size: 36px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 40px;
            line-height: 1.2;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: #f8f9fa;
            box-sizing: border-box;
        }

        .form-control::placeholder {
            color: #999;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #4CAF50;
            background: white;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .form-control.is-invalid {
            border-color: #e74c3c;
        }

        .invalid-feedback {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .form-check-input {
            margin-right: 12px;
            transform: scale(1.1);
        }

        .form-check-label {
            color: #666;
            font-size: 14px;
        }

        .btn-primary {
            width: 100%;
            padding: 16px;
            background: #2196F3;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
        }

        .btn-primary:hover {
            background: #1976D2;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(139, 195, 74, 0.3);
        }

        .social-login {
            text-align: center;
            margin-bottom: 24px;
        }

        .social-login-text {
            color: #999;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .social-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .social-btn {
            width: 100%;
            max-width: 200px;
            height: 44px;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            background: white;
            color: #333;
            gap: 8px;
        }

        .google-icon {
            width: 18px;
            height: 18px;
        }

        .social-btn:hover {
            border-color: #8BC34A;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .terms-text {
            font-size: 12px;
            color: #999;
            text-align: center;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .terms-text a {
            color: #8BC34A;
            text-decoration: none;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .register-link a {
            color: #8BC34A;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: none;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                margin: 10px;
                min-height: auto;
            }

            .login-illustration {
                padding: 30px 20px;
                min-height: 250px;
            }

            .login-form {
                padding: 30px 25px;
            }

            .form-title {
                font-size: 28px;
            }
        }
    </style>

    <div class="login-container">
        <!-- Left Side - Illustration -->
        <div class="login-illustration">
            <div class="illustration-content">
                <!-- GANTI dengan path gambar ilustrasi -->
                <img src="{{ asset('img/shaka_utama.png') }}" alt="Login Illustration" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-form">
            <!-- Brand -->
            <div class="brand">
                <div class="brand-icon">
                    <!-- GANTI dengan path logo Anda -->
                    <img src="{{ asset('img/msa.png') }}" alt="Logo BPR MSA">
                </div>
                <div class="brand-name">Credit Scoring PT BPR MSA</div>
            </div>

            <h1 class="form-title">Login ke<br>akun Anda</h1>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Address -->
                <div class="form-group">
                    <input 
                        id="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        placeholder="Email address"
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <input 
                        id="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="Password"
                    >
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label" for="remember_me">
                        Ingat saya
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary">
                    Login ke akun
                </button>

                <!-- Social Login -->
                <div class="social-login">
                    <p class="social-login-text">atau masuk dengan</p>
                    <div class="social-buttons">
                        <a href="#" class="social-btn">
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
                <div class="terms-text">
                    Dengan login Anda setuju dengan <a href="#">Terms of Services</a> dan <a href="#">Privacy Policy</a> BPR MSA
                </div>

                <!-- Register Link -->
                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <div style="text-align: center; margin-top: 15px;">
                        <a style="color: #8BC34A; text-decoration: none; font-size: 14px;" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>