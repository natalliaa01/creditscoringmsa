<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hubungi Kami') }}
        </h2>
    </x-slot>

    <!-- Boxicons CSS for icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom Styles to Match Landing Page -->
    <style>
        .hero-contact {
            background: linear-gradient(135deg, #4a90e2, #357abd);
            color: white;
            text-align: center;
            padding: 80px 20px;
            position: relative;
        }
        .hero-contact::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
        }
        .hero-contact > * {
            position: relative;
            z-index: 1;
        }
        .hero-contact h1 {
            font-size: 42px;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .hero-contact p {
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
            opacity: 0.95;
        }

        .contact-main-section {
            padding: 80px 5%;
            background-color: #f8f9fa;
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        .contact-info-card {
            background: white;
            padding: 50px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            height: fit-content;
        }

        .contact-info-card h2 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #2c3e50;
            font-weight: 600;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #4a90e2;
            transition: all 0.3s ease;
        }
        .contact-item:hover {
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateX(5px);
        }

        .contact-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #4a90e2, #357abd);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
        }

        .contact-details h4 {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .contact-details p {
            color: #666;
            font-size: 15px;
            line-height: 1.5;
            margin: 0;
        }

        .contact-details a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 500;
        }
        .contact-details a:hover {
            text-decoration: underline;
        }

        .social-media-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #f0f0f0;
        }
        .social-media-section h3 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: 600;
        }
        .social-links {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .social-links a {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4a90e2, #357abd);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .social-links a:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(74, 144, 226, 0.3);
        }

        .contact-form-card {
            background: white;
            padding: 50px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .contact-form-card h2 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #2c3e50;
            font-weight: 600;
            text-align: center;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 16px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4a90e2;
            background: white;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 18px 30px;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }

        .success-message {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            font-weight: 500;
        }

        /* Map Section */
        .map-section {
            padding: 80px 5%;
            background-color: white;
            text-align: center;
        }
        .map-section h2 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: 600;
        }
        .map-section p {
            font-size: 18px;
            color: #666;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .map-container {
            max-width: 1000px;
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .map-container iframe {
            width: 100%;
            height: 400px;
            border: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-contact {
                padding: 60px 20px;
            }
            .hero-contact h1 {
                font-size: 28px;
            }
            .hero-contact p {
                font-size: 16px;
            }

            .contact-main-section {
                padding: 60px 5%;
            }
            .contact-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .contact-info-card,
            .contact-form-card {
                padding: 30px 25px;
            }

            .contact-info-card h2,
            .contact-form-card h2 {
                font-size: 26px;
            }

            .contact-item {
                padding: 15px;
            }
            .contact-icon {
                width: 40px;
                height: 40px;
                margin-right: 15px;
                font-size: 18px;
            }

            .social-links a {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }

            .map-section {
                padding: 60px 5%;
            }
            .map-section h2 {
                font-size: 28px;
            }
            .map-container iframe {
                height: 300px;
            }
        }
    </style>

    <div class="min-h-screen">
        <!-- Hero Section -->
        <section class="hero-contact">
            <h1>Hubungi Kami</h1>
            <p>Kami siap membantu Anda dengan segala kebutuhan perbankan dan layanan keuangan. Jangan ragu untuk menghubungi tim profesional kami.</p>
        </section>

        <!-- Contact Main Section -->
        <section class="contact-main-section">
            <div class="contact-container">
                <!-- Contact Information -->
                <div class="contact-info-card">
                    <h2>Informasi Kontak</h2>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class='bx bx-map'></i>
                        </div>
                        <div class="contact-details">
                            <h4>Alamat Kantor</h4>
                            <p>Jalan C. Simanjuntak No. 26<br>Kota Yogyakarta 55223<br>Daerah Istimewa Yogyakarta</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class='bx bx-phone'></i>
                        </div>
                        <div class="contact-details">
                            <h4>Telepon</h4>
                            <p><a href="tel:0274549400">0274-549400</a></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class='bx bxl-whatsapp'></i>
                        </div>
                        <div class="contact-details">
                            <h4>WhatsApp Business</h4>
                            <p><a href="https://wa.me/6285172024202">0851-7202-4202</a></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class='bx bx-envelope'></i>
                        </div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p><a href="mailto:bprmadani@gmail.com">bprmadani@gmail.com</a></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class='bx bx-time'></i>
                        </div>
                        <div class="contact-details">
                            <h4>Jam Operasional</h4>
                            <p>Senin – Jumat: 08.00 – 17.00 WIB</p>
                        </div>
                    </div>

                    <div class="social-media-section">
                        <h3>Ikuti Media Sosial Kami</h3>
                        <div class="social-links">
                            <a href="https://instagram.com/bprmsa.official" title="Instagram" target="_blank" rel="noopener noreferrer">
                                <i class='bx bxl-instagram'></i>
                            </a>
                            <a href="https://facebook.com/bprmsa.official" title="Facebook" target="_blank" rel="noopener noreferrer">
                                <i class='bx bxl-facebook'></i>
                            </a>
                            <a href="https://twitter.com/bprmsa" title="Twitter" target="_blank" rel="noopener noreferrer">
                                <i class='bx bxl-twitter'></i>
                            </a>
                            <a href="https://youtube.com/@bprmsa" title="YouTube" target="_blank" rel="noopener noreferrer">
                                <i class='bx bxl-youtube'></i>
                            </a>
                            <a href="https://tiktok.com/@bprmsa" title="TikTok" target="_blank" rel="noopener noreferrer">
                                <i class='bx bxl-tiktok'></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-card">
                    <h2>Kirim Pesan Anda</h2>

                    @if(session('success'))
                        <div class="success-message">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap Anda" required value="{{ old('name') }}">
                            @error('name')<div class="error-message">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="Masukkan alamat email Anda" required value="{{ old('email') }}">
                            @error('email')<div class="error-message">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="subject">Subjek Pesan</label>
                            <select id="subject" name="subject" required>
                                <option value="">Pilih subjek pesan</option>
                                <option value="informasi_produk" {{ old('subject') == 'informasi_produk' ? 'selected' : '' }}>Informasi Produk</option>
                                <option value="kerjasama_umkm" {{ old('subject') == 'kerjasama_umkm' ? 'selected' : '' }}>Kerja Sama UMKM</option>
                                <option value="bantuan_umum" {{ old('subject') == 'bantuan_umum' ? 'selected' : '' }}>Bantuan Umum</option>
                                <option value="lainnya" {{ old('subject') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('subject')<div class="error-message">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="message">Isi Pesan</label>
                            <textarea id="message" name="message" placeholder="Tulis pesan Anda di sini..." required>{{ old('message') }}</textarea>
                            @error('message')<div class="error-message">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="submit-btn">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section class="map-section">
            <h2>Lokasi Kami</h2>
            <p>Temukan kantor BPR Madani Sejahtera Abadi dengan mudah melalui peta di bawah ini. Kami siap melayani Anda dengan profesional.</p>

            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.1895697298647!2d110.37525387431548!3d-7.772591677271008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a582310860549%3A0x6a05d8f6f5b9d3e8!2sJl.+C.+Simanjuntak+No.26%2C+Terban%2C+Kecamatan+Gondokusuman%2C+Kota+Yogyakarta%2C+Daerah+Istimewa+Yogyakarta+55223!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
        </section>
    </div>
</x-app-layout>
