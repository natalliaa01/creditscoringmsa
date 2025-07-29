<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Scoring - BPR Madani Sejahtera Abadi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #333;
            line-height: 1.6;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 5%;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header .logo {
            display: flex;
            align-items: center;
        }
        .header .logo img {
            height: 50px;
            margin-right: 15px;
            border-radius: 8px;
        }
        .header .logo h1 {
            font-size: 24px;
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }
        .nav-menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .nav-menu ul li {
            margin-left: 30px;
        }
        .nav-menu ul li a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            font-size: 16px;
            transition: color 0.3s ease;
            padding: 8px 0;
        }
        .nav-menu ul li a:hover {
            color: #4a90e2;
        }
        .auth-buttons a.auth-btn {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            margin-left: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .auth-buttons a.auth-btn:hover {
            background-color: #357abd;
            transform: translateY(-2px);
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 120px 20px;
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
            font-size: 48px;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .hero-section p {
            font-size: 20px;
            max-width: 800px;
            margin: 0 auto 40px auto;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
            opacity: 0.95;
        }
        .hero-section .cta-button {
            background-color: #28a745;
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
            background-color: #218838;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }
        .content-section {
            padding: 80px 5%;
            text-align: center;
            background-color: #f8f9fa;
        }
        .content-section h2 {
            font-size: 36px;
            margin-bottom: 30px;
            color: #2c3e50;
            font-weight: 600;
        }
        .content-section p {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 25px;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
            color: #555;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 60px 5% 20px 5%;
        }
        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-column {
            flex: 1;
            min-width: 250px;
            margin-bottom: 30px;
        }
        .footer-column h3 {
            color: #4a90e2;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 600;
        }
        .footer-column p, .footer-column a {
            color: #bdc3c7;
            text-decoration: none;
            line-height: 1.8;
            margin-bottom: 8px;
        }
        .footer-column a:hover {
            color: #fff;
            transition: color 0.3s ease;
        }
        .social-media {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }
        .social-media img {
            height: 32px;
            width: 32px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .social-media img:hover {
            transform: translateY(-3px);
            opacity: 0.8;
        }
        .map-section {
            margin-top: 40px;
            padding-top: 40px;
            border-top: 1px solid #34495e;
        }
        .map-section h3 {
            color: #4a90e2;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
            text-align: center;
        }
        .map-section p {
            text-align: center;
            color: #bdc3c7;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .map-section iframe {
            width: 100%;
            height: 350px;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .footer-bottom {
            width: 100%;
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #34495e;
            color: #95a5a6;
            font-size: 14px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                padding: 20px;
            }
            .nav-menu ul {
                margin-top: 20px;
                flex-direction: column;
                align-items: center;
            }
            .nav-menu ul li {
                margin: 8px 0;
            }
            .auth-buttons {
                margin-top: 20px;
            }
            .hero-section {
                padding: 80px 20px;
            }
            .hero-section h2 {
                font-size: 32px;
            }
            .hero-section p {
                font-size: 16px;
            }
            .content-section {
                padding: 60px 5%;
            }
            .footer-content {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .footer-column {
                min-width: unset;
                width: 100%;
            }
            .social-media {
                justify-content: center;
            }
            .map-section iframe {
                height: 300px;
            }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="logo">
            <img src="{{ asset('img/msa.png') }}" alt="Logo Aplikasi">
            <h1>Credit Scoring System</h1>
        </div>
        <nav class="nav-menu">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="{{ route('About') }}" class="auth-btn">Tentang Kami</a></li>
                <li><a href="{{ route('contact us') }}" class="auth-btn">Kontak</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="{{ route('login') }}" class="auth-btn">Login</a>
            <a href="{{ route('register') }}" class="auth-btn">Registrasi</a>
        </div>
    </header>

    <section id="home" class="hero-section">
        <h2>Optimalkan Keuangan Anda dengan Credit Scoring</h2>
        <p>Dapatkan analisis kredit yang akurat dan cepat untuk membantu Anda mengambil keputusan finansial yang lebih baik dengan teknologi terdepan.</p>
        <a href="#about" class="cta-button">Pelajari Lebih Lanjut</a>
    </section>

    <footer id="contact" class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>BPR MADANI SEJAHTERA ABADI</h3>
                <p>Jalan C. Simanjuntak No. 26</p>
                <p>Kota Yogyakarta 55223</p>
                <p>Daerah Istimewa Yogyakarta</p>
            </div>
            <div class="footer-column">
                <h3>Hubungi Kami</h3>
                <p>Telpon: <a href="tel:0274549400">0274-549400</a></p>
                <p>WhatsApp Business: <a href="https://wa.me/6285172024202">0851-7202-4202</a></p>
                <p>E-mail: <a href="mailto:bprmadani@gmail.com">bprmadani@gmail.com</a></p>
            </div>
            <div class="footer-column">
                <h3>Ikuti Kami</h3>
                <div class="social-media">
                    <a href="#"><img src="https://via.placeholder.com/32x32/3b5998/ffffff?text=F" alt="Facebook"></a>
                    <a href="#"><img src="https://via.placeholder.com/32x32/E4405F/ffffff?text=I" alt="Instagram"></a>
                    <a href="#"><img src="https://via.placeholder.com/32x32/1DA1F2/ffffff?text=T" alt="Twitter"></a>
                    <a href="#"><img src="https://via.placeholder.com/32x32/FF0000/ffffff?text=Y" alt="YouTube"></a>
                </div>
            </div>
        </div>

        <div class="map-section">
            <h3>Lokasi Kami</h3>
            <p>Temukan kami dengan mudah di peta di bawah ini. Kami siap melayani Anda dengan profesional.</p>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.1895697298647!2d110.37525387431548!3d-7.772591677271008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a582310860549%3A0x6a05d8f6f5b9d3e8!2sJl.+C.+Simanjuntak+No.26%2C+Terban%2C+Kecamatan+Gondokusuman%2C+Kota+Yogyakarta%2C+Daerah+Istimewa+Yogyakarta+55223!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 BPR MADANI SEJAHTERA ABADI. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>