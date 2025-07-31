<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Credit Scoring System') }}
        </h2>
    </x-slot>

    <!-- Custom Styles -->
    <style>
        .hero-section {
            background: url('/img/msa1.jpeg') no-repeat center center;
            background-size: cover;
            color: white;
            text-align: center;
            padding: 100px 20px;
            position: relative;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
        }
        .hero-section > * {
            position: relative;
            z-index: 1;
        }
        .hero-section h2 {
            font-size: 42px;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .hero-section p {
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto 40px auto;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
            opacity: 0.95;
        }
        .hero-section .cta-button {
            background-color: #0047AB;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .hero-section .cta-button:hover {
            background-color: #1976D2;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(33, 150, 243, 0.3);
        }

        .features-section {
            padding: 80px 5%;
            background-color: #f8f9fa;
        }
        .features-section h2 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 50px;
            color: #2c3e50;
            font-weight: 600;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4a90e2, #357abd);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            color: white;
        }
        .feature-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        .feature-card p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }

        .services-section {
            padding: 80px 5%;
            background-color: white;
        }
        .services-section h2 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 30px;
            color: #2c3e50;
            font-weight: 600;
        }
        .services-section .subtitle {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin-bottom: 50px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .service-item {
            background: #f8f9fa;
            padding: 30px 25px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid #4a90e2;
            transition: all 0.3s ease;
        }
        .service-item:hover {
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .service-item h4 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        .service-item p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }

        .cta-section {
            background: linear-gradient(135deg, #2196F3, black);
            color: white;
            text-align: center;
            padding: 60px 20px;
        }
        .cta-section h2 {
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .cta-section p {
            font-size: 18px;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .cta-buttons a {
            background-color: white;
            color: #2196F3;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .cta-buttons a:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .cta-buttons a.secondary {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }
        .cta-buttons a.secondary:hover {
            background-color: white;
            color: #2196F3;
        }

        .footer-custom {
            background-color: #2c3e50;
            color: white;
            padding: 25px 5% 10px 5%;
        }
        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 20px;
            align-items: start;
            max-width: 1200px;
            margin: 0 auto;
        }
        .footer-column {
            text-align: left;
        }
        .footer-column h3 {
            color: #4a90e2;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 600;
        }
        .footer-column p, .footer-column a {
            color: #bdc3c7;
            text-decoration: none;
            line-height: 1.4;
            margin-bottom: 3px;
            font-size: 12px;
        }
        .footer-column a:hover {
            color: #fff;
            transition: color 0.3s ease;
        }
        
        .contact-icons {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
        }
        .contact-icon {
            width: 16px;
            height: 16px;
            background: #4a90e2;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: white;
            flex-shrink: 0;
        }
        
        .social-media {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .social-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            font-size: 18px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .social-icon.instagram {
            background: linear-gradient(45deg, #405DE6, #5B51D8, #833AB4, #C13584, #E1306C, #FD1D1D, #F56040, #FFDC80);
        }
        
        .social-icon.facebook {
            background: #1877F2;
        }
        
        .social-icon.tiktok {
            background: #000000;
        }
        
        .social-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .social-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .social-icon:hover::before {
            opacity: 1;
        }
        
        .map-container {
            text-align: center;
        }
        .map-container h3 {
            color: #4a90e2;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
        }
        .map-container iframe {
            width: 100%;
            height: 120px;
            border: 0;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        
        .footer-bottom {
            width: 100%;
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #34495e;
            color: #95a5a6;
            font-size: 11px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 20px;
            }
            .hero-section h2 {
                font-size: 32px;
            }
            .hero-section p {
                font-size: 16px;
            }
            .features-section, .services-section {
                padding: 60px 5%;
            }
            .cta-section {
                padding: 50px 20px;
            }
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            .footer-custom {
                padding: 20px 5% 10px 5%;
            }
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 15px;
            }
            .footer-column {
                text-align: center;
            }
            .contact-icons {
                align-items: center;
            }
            .social-media {
                justify-content: center;
            }
            .map-container iframe {
                height: 100px;
            }
            .features-grid {
                gap: 40px;
            }
            .feature-card {
                margin-bottom: 20px;
            }
        }
    </style>

    <div class="min-h-screen bg-white">
        <!-- Hero Section -->
        <section id="home" class="hero-section">
            <h2>Sistem Credit Scoring Terpercaya</h2>
            <p>Solusi analisis kredit modern untuk BPR Madani Sejahtera Abadi. Evaluasi risiko kredit dengan akurat dan efisien menggunakan teknologi terdepan.</p>
            <a href="{{ route('register') }}" class="cta-button">Mulai Sekarang</a>
        </section>

        <!-- Features Section -->
        <section id="features" class="features-section">
            <h2>Keunggulan Sistem Kami</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Analisis Komprehensif</h3>
                    <p>Evaluasi mendalam terhadap profil keuangan nasabah dengan berbagai parameter scoring yang akurat dan terpercaya.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Proses Cepat</h3>
                    <p>Dapatkan hasil analisis kredit dalam hitungan menit dengan sistem otomatis yang efisien dan real-time.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Keamanan Terjamin</h3>
                    <p>Data nasabah dilindungi dengan enkripsi tingkat tinggi dan sistem keamanan berlapis untuk menjaga privasi.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📈</div>
                    <h3>Laporan Detail</h3>
                    <p>Laporan komprehensif dengan visualisasi data yang mudah dipahami untuk mendukung keputusan kredit.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Akurasi Tinggi</h3>
                    <p>Algoritma machine learning yang terus diperbarui untuk memberikan prediksi risiko dengan tingkat akurasi optimal.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>User-Friendly</h3>
                    <p>Interface yang intuitif dan mudah digunakan, dapat diakses dari berbagai perangkat kapan saja.</p>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section">
            <h2>Layanan Credit Scoring</h2>
            <p class="subtitle">Berbagai layanan analisis kredit yang disesuaikan dengan kebutuhan BPR Madani Sejahtera Abadi</p>
            <div class="services-grid">
                <div class="service-item">
                    <h4>Scoring Individu</h4>
                    <p>Analisis kredit untuk nasabah perorangan dengan evaluasi kemampuan bayar dan riwayat keuangan.</p>
                </div>
                <div class="service-item">
                    <h4>Scoring UMKM</h4>
                    <p>Penilaian khusus untuk usaha mikro, kecil, dan menengah dengan parameter bisnis yang relevan.</p>
                </div>
                <div class="service-item">
                    <h4>Monitoring Portofolio</h4>
                    <p>Pemantauan berkelanjutan terhadap performa kredit dan deteksi dini risiko gagal bayar.</p>
                </div>
                <div class="service-item">
                    <h4>Analisis Trend</h4>
                    <p>Insight dan tren pasar untuk membantu strategi pengembangan produk kredit bank.</p>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <h2>Siap Meningkatkan Analisis Kredit Anda?</h2>
            <p>Bergabunglah dengan BPR Madani Sejahtera Abadi dan rasakan kemudahan sistem credit scoring yang modern dan terpercaya.</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}">Daftar Sekarang</a>
                <a href="{{ route('contact') }}" class="secondary">Hubungi Kami</a>
            </div>
        </section>

        <!-- Footer -->
        <footer id="contact" class="footer-custom">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>BPR MADANI SEJAHTERA ABADI</h3>
                    <p>Jalan C. Simanjuntak No. 26</p>
                    <p>Kota Yogyakarta 55223</p>
                    <p>Daerah Istimewa Yogyakarta</p>
                </div>
                <div class="footer-column">
                    <h3>Hubungi Kami</h3>
                    <div class="contact-icons">
                        <div class="contact-item">
                            <div class="contact-icon">📞</div>
                            <a href="tel:0274549400">0274-549400</a>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">💬</div>
                            <a href="https://wa.me/6285172024202">0851-7202-4202</a>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">✉</div>
                            <a href="mailto:bprmadani@gmail.com">bprmadani@gmail.com</a>
                        </div>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Ikuti Kami</h3>
                    <div class="social-media">
                        <a href="https://www.instagram.com/bprmsa.official/" target="_blank" class="social-icon instagram" aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.31.975.975 1.248 2.242 1.31 3.608.058 1.266.07 1.646.07 4.849s-.012 3.583-.07 4.849c-.062 1.366-.335 2.633-1.31 3.608-.975.975-2.242 1.248-3.608 1.31-1.266.058-1.646.07-4.85.07s-3.584-.012-4.849-.07c-1.366-.062-2.633-.335-3.608-1.31-.975-.975-1.248-2.242-1.31-3.608-.058-1.266-.07-1.646-.07-4.849s.012-3.583.07-4.849c.062-1.366.335-2.633 1.31-3.608.975-.975 2.242-1.248 3.608-1.31 1.265-.058 1.645-.07 4.849-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.281.058-2.15.267-2.912.568-.79.31-1.459.724-2.126 1.391-.667.667-1.081 1.336-1.391 2.126-.301.762-.51 1.631-.568 2.912-.058 1.28-.072 1.688-.072 4.947s.014 3.667.072 4.947c.058 1.281.267 2.15.568 2.912.31.79.724 1.459 1.391 2.126.667.667 1.336 1.081 2.126 1.391.762.301 1.631.51 2.912.568 1.28.058 1.688.072 4.947.072s3.667-.014 4.947-.072c1.281-.058 2.15-.267 2.912-.568.79-.31 1.459-.724 2.126-1.391.667-.667 1.081-1.336 1.391-2.126.301-.762.51-1.631.568-2.912.058-1.28.072-1.688.072-4.947s-.014-3.667-.072-4.947c-.058-1.281-.267-2.15-.568-2.912-.31-.79-.724-1.459-1.391-2.126-.667-.667-1.336-1.081-2.126-1.391-.762-.301-1.631-.51-2.912-.568-1.28-.058-1.688-.072-4.947-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="https://web.facebook.com/bprmsa.official?_rdc=1&_rdr" target="_blank" class="social-icon facebook" aria-label="Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://www.tiktok.com/@bprmsa" target="_blank" class="social-icon tiktok" aria-label="TikTok">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="footer-column map-container">
                    <h3>Lokasi Kami</h3>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.1895697298647!2d110.37525387431548!3d-7.772591677271008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a582310860549%3A0x6a05d8f6f5b9d3e8!2sJl.+C.+Simanjuntak+No.26%2C+Terban%2C+Kecamatan+Gondokusuman%2C+Kota+Yogyakarta%2C+Daerah+Istimewa+Yogyakarta+55223!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 BPR MADANI SEJAHTERA ABADI. Hak Cipta Dilindungi.</p>
            </div>
        </footer>
    </div>
</x-app-layout>