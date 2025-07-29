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
            padding: 20px;
        }

        .forgot-container {
            display: flex;
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            min-height: 600px;
        }

        .forgot-illustration {
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

        .forgot-form {
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
            width: 48px;
            height: 48px;
            margin-right: 16px;
            border-radius: 4px;
            overflow: hidden;
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-name {
            font-size: 18px;
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

        .form-description {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 32px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #2196F3;
        }

        .form-group {
            margin-bottom: 24px;
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
            border-color: #2196F3;
            background: white;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        .form-control.is-invalid {
            border-color: #e74c3c;
        }

        .invalid-feedback {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
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
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
        }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            border: none;
            font-size: 14px;
            line-height: 1.4;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .back-link {
            text-align: center;
            margin-top: 24px;
        }

        .back-link a {
            color: #2196F3;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .forgot-icon {
            font-size: 48px;
            color: #2196F3;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .forgot-container {
                flex-direction: column;
                margin: 10px;
                min-height: auto;
            }

            .forgot-illustration {
                padding: 30px 20px;
                min-height: 250px;
            }

            .forgot-form {
                padding: 30px 25px;
            }

            .form-title {
                font-size: 28px;
            }

            .brand-icon {
                width: 40px;
                height: 40px;
                margin-right: 12px;
            }

            .brand-name {
                font-size: 16px;
            }
        }
    </style>

    <div class="forgot-container">
        <!-- Left Side - Illustration -->
        <div class="forgot-illustration">
            <div class="illustration-content">
                <!-- GANTI dengan path gambar ilustrasi -->
                <img src="{{ asset('img/shaka_utama.png') }}" alt="Forgot Password Illustration" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
        </div>

        <!-- Right Side - Forgot Password Form -->
        <div class="forgot-form">
            <!-- Brand -->
            <div class="brand">
                <div class="brand-icon">
                    <!-- GANTI dengan path logo Anda -->
                    <img src="{{ asset('img/msa.png') }}" alt="Logo BPR MSA">
                </div>
                <div class="brand-name">Credit Scoring PT BPR MSA</div>
            </div>

            <div class="forgot-icon">
                🔒
            </div>

            <h1 class="form-title">Lupa<br>Password?</h1>

            <!-- Description -->
            <div class="form-description">
                {{ __('Lupa password Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan reset password melalui email yang memungkinkan Anda memilih password baru.') }}
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
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
                        placeholder="Masukkan alamat email Anda"
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary">
                    {{ __('Kirim Link Reset Password') }}
                </button>

                <!-- Back to Login Link -->
                <div class="back-link">
                    <a href="{{ route('login') }}">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>