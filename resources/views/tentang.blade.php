<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tentang Kami') }}
        </h2>
    </x-slot>

    <!-- Boxicons CSS for icons (added for consistency, assuming it's used elsewhere) -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom Styles to Match Landing Page -->
    <style>
        .hero-about {
            background: linear-gradient(135deg, #4a90e2, #357abd);
            color: white;
            text-align: center;
            padding: 60px 20px; /* Disesuaikan untuk lebih ringkas */
            position: relative;
        }
        .hero-about::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
        }
        .hero-about > * {
            position: relative;
            z-index: 1;
        }
        .hero-about h1 {
            font-size: 38px; /* Disesuaikan */
            margin-bottom: 15px; /* Disesuaikan */
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .hero-about p {
            font-size: 17px; /* Disesuaikan */
            max-width: 800px;
            margin: 0 auto;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
            opacity: 0.95;
        }

        .content-section {
            padding: 60px 5%; /* Disesuaikan */
            background-color: white;
        }
        .content-section.alt {
            background-color: #f8f9fa;
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px; /* Disesuaikan */
            align-items: center;
        }
        .section-container.reverse {
            grid-template-columns: 1fr 1fr;
        }

        .content-text h3 {
            font-size: 28px; /* Disesuaikan */
            margin-bottom: 20px; /* Disesuaikan */
            color: #2c3e50;
            font-weight: 600;
        }
        .content-text h3.visi {
            color: #4a90e2;
        }
        .content-text h3.misi {
            color: #28a745;
        }

        .content-text p {
            color: #666;
            font-size: 17px; /* Disesuaikan */
            line-height: 1.6; /* Disesuaikan */
            margin-bottom: 15px; /* Disesuaikan */
        }

        .content-text ol {
            color: #666;
            font-size: 15px; /* Disesuaikan */
            line-height: 1.6; /* Disesuaikan */
            padding-left: 20px;
        }
        .content-text ol li {
            margin-bottom: 8px; /* Disesuaikan */
            padding-left: 10px;
        }

        .content-image {
            text-align: center;
        }
        .content-image img {
            width: 100%;
            max-width: 500px;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
        }
        .content-image img:hover {
            transform: translateY(-5px);
        }

        .logo-section {
            padding: 60px 5%; /* Disesuaikan */
            background-color: white;
            text-align: center;
        }
        .logo-section h3 {
            font-size: 32px; /* Disesuaikan */
            margin-bottom: 30px; /* Disesuaikan */
            color: #2c3e50;
            font-weight: 600;
        }
        .logo-section img {
            max-width: 400px;
            width: 100%;
            height: auto;
            margin: 0 auto;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,0.1));
        }

        .contact-section {
            background: linear-gradient(135deg, #4a90e2, black);
            color: white;
            padding: 60px 5%; /* Disesuaikan */
            text-align: center;
        }
        .contact-section h2 {
            font-size: 32px; /* Disesuaikan */
            margin-bottom: 25px; /* Disesuaikan */
            font-weight: 600;
        }
        .contact-section p {
            font-size: 17px; /* Disesuaikan */
            margin-bottom: 30px; /* Disesuaikan */
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0.95;
        }
        .contact-info {
            display: grid;
            /* Mengubah menjadi 3 kolom agar sejajar di satu baris pada layar lebar */
            grid-template-columns: repeat(3, 1fr);
            gap: 20px; /* Mengurangi jarak antar item */
            max-width: 900px; /* Sedikit dilebarkan untuk menampung 3 kolom */
            margin: 0 auto;
        }
        .contact-item {
            background: rgba(255,255,255,0.1);
            padding: 20px; /* Disesuaikan */
            border-radius: 12px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .contact-item:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-5px);
        }
        .contact-item i {
            font-size: 28px; /* Disesuaikan */
            margin-bottom: 10px; /* Disesuaikan */
            display: block;
        }
        .contact-item h4 {
            font-size: 18px; /* Disesuaikan */
            margin-bottom: 8px; /* Disesuaikan */
            font-weight: 600;
        }
        .contact-item a {
            color: white;
            text-decoration: none;
            font-size: 16px; /* Disesuaikan */
            font-weight: 500;
        }
        .contact-item a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-about {
                padding: 50px 20px; /* Lebih kecil untuk mobile */
            }
            .hero-about h1 {
                font-size: 26px; /* Lebih kecil untuk mobile */
            }
            .hero-about p {
                font-size: 15px; /* Lebih kecil untuk mobile */
            }

            .content-section {
                padding: 50px 5%; /* Lebih kecil untuk mobile */
            }
            .section-container {
                grid-template-columns: 1fr; /* Kembali ke satu kolom untuk mobile */
                gap: 30px; /* Disesuaikan */
                text-align: center;
            }
            .section-container.reverse {
                grid-template-columns: 1fr;
            }
            .content-text {
                order: 2; /* Memastikan teks di bawah gambar di mobile */
            }
            .content-image {
                order: 1;
            }
            .section-container.reverse .content-text {
                order: 2;
            }
            .section-container.reverse .content-image {
                order: 1;
            }

            .content-text h3 {
                font-size: 24px; /* Lebih kecil untuk mobile */
            }
            .content-text p {
                font-size: 15px; /* Lebih kecil untuk mobile */
            }
            .content-text ol {
                font-size: 14px; /* Lebih kecil untuk mobile */
                text-align: left;
            }

            .logo-section {
                padding: 50px 5%; /* Lebih kecil untuk mobile */
            }
            .logo-section h3 {
                font-size: 26px; /* Lebih kecil untuk mobile */
            }

            .contact-section {
                padding: 50px 5%; /* Lebih kecil untuk mobile */
            }
            .contact-section h2 {
                font-size: 26px; /* Lebih kecil untuk mobile */
            }
            .contact-section p {
                font-size: 15px; /* Lebih kecil untuk mobile */
            }
            .contact-info {
                grid-template-columns: 1fr; /* Kembali ke satu kolom untuk mobile */
                gap: 15px; /* Disesuaikan */
            }
            .contact-item {
                padding: 15px; /* Lebih kecil untuk mobile */
            }
            .contact-item i {
                font-size: 24px; /* Lebih kecil untuk mobile */
            }
            .contact-item h4 {
                font-size: 16px; /* Lebih kecil untuk mobile */
            }
            .contact-item a {
                font-size: 15px; /* Lebih kecil untuk mobile */
            }
        }
    </style>

    <div class="min-h-screen">
        <!-- Hero Section -->
        <section class="hero-about">
            <h1>Mengenal Lebih Dekat PT BPR MSA</h1>
            <p>Bank Perkreditan Rakyat yang berkomitmen untuk menjadi "Smart Banking" terbaik di Indonesia dengan melayani masyarakat secara profesional dan terpercaya.</p>
        </section>

        <!-- Visi Section -->
        <section class="content-section">
            <div class="section-container">
                <div class="content-text">
                    <h3 class="visi">Visi Kami</h3>
                    <p>Menjadi "Smart Banking" BPR terbaik di Indonesia dengan mengutamakan pelayanan prima, teknologi modern, dan prinsip kehati-hatian dalam setiap aspek bisnis perbankan.</p>
                </div>
                <div class="content-image">
                    <img src="{{ asset('img/msa1.jpeg') }}" alt="Gedung BPR MSA">
                </div>
            </div>
        </section>

        <!-- Misi Section -->
        <section class="content-section alt">
            <div class="section-container reverse">
                <div class="content-image">
                    <img src="{{ asset('img/timbpr.png') }}" alt="Tim BPR MSA">
                </div>
                <div class="content-text">
                    <h3 class="misi">Misi Kami</h3>
                    <ol>
                        <li>Terciptanya Good Corporate Governance, berbasis pada Perbankan yang sehat.</li>
                        <li>Menjalankan bisnis perbankan secara prudent (mengutamakan prinsip kehati-hatian) dengan tidak mengesampingkan pertumbuhan bisnis.</li>
                        <li>Menjadi partner bisnis bagi usaha mikro, kecil dan menengah untuk menunjang peningkatan ekonomi regional.</li>
                        <li>Memberikan pelayanan prima untuk memuaskan nasabah.</li>
                        <li>Memberikan keuntungan dan manfaat yang optimal kepada stake holder.</li>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Logo Section -->
        <section class="logo-section">
            <h3>Kami Adalah BPR MSA</h3>
            <img src="{{ asset('img/msa.png') }}" alt="Logo Besar BPR MSA">
        </section>

        <!-- Contact Section -->
        <section class="contact-section">
            <h2>Hubungi Kami</h2>
            <p>Jika Anda memiliki pertanyaan lebih lanjut atau ingin menjadi bagian dari UMKM binaan kami, jangan ragu untuk menghubungi tim kami. Kami siap melayani Anda dengan profesional.</p>

            <div class="contact-info">
                <div class="contact-item">
                    <i class='bx bx-envelope'></i>
                    <h4>Email</h4>
                    <a href="mailto:bprmadani@gmail.com">bprmadani@gmail.com</a>
                </div>
                <div class="contact-item">
                    <i class='bx bx-phone'></i>
                    <h4>Telepon</h4>
                    <a href="tel:0274-549400">0274-549400</a>
                </div>
                <div class="contact-item">
                    <i class='bx bxl-whatsapp'></i>
                    <h4>WhatsApp</h4>
                    <a href="https://wa.me/6285172024202">0851-7202-4202</a>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
