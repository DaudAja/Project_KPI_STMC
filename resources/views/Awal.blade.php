<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STMC Klinik | Manajemen Surat Modern</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary-color: #0d6efd;
            --accent-color: #18bc9c;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff;
        }

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 110vh; /* Lebih tinggi untuk menampung fitur */
            background: url('{{ asset("Images/bg.jpg") }}') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 80px;
            padding-bottom: 200px; /* Ruang untuk gelombang */
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.85) 0%, rgba(24, 188, 156, 0.8) 100%);
        }

        /* Glassmorphism Card Utama */
        .glass-card {
            position: relative;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 40px;
            color: white;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            max-width: 900px;
            width: 90%;
            z-index: 2;
        }

        /* Fitur Card di dalam area Biru */
        .feature-box {
            position: relative;
            z-index: 2;
            color: white;
            margin-top: 60px;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            transition: 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-10px);
        }

        .logo-glow {
            filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.5));
        }

        .btn-modern {
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login {
            background: white;
            color: var(--primary-color);
            border: none;
        }

        .btn-login:hover {
            background: var(--accent-color);
            color: white;
        }

        /* CSS untuk Gelombang Putih */
        .wave-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            line-height: 0;
            z-index: 1;
        }

        .wave-container svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 150px;
        }

        .wave-container .shape-fill {
            fill: #FFFFFF;
        }
    </style>
</head>
<body>

    <section class="hero text-center">
        <div class="glass-card animate__animated animate__fadeInDown mb-5">
            <img src="{{ asset('Images/logoST.png') }}" alt="Logo" width="100" class="logo-glow mb-4">
            <h1 class="display-4 fw-bold mb-2">STMC DIGITAL</h1>
            <p class="fs-5 mb-4 opacity-75">Manajemen arsip surat klinik terintegrasi dan aman.</p>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-modern btn-login shadow">
                    <i class="bi bi-door-open-fill me-2"></i> Masuk Sistem
                </a>
                <a href="{{ route('register') }}" class="btn btn-modern btn-outline-light">
                    <i class="bi bi-person-plus-fill me-2"></i> Daftar Akun
                </a>
            </div>
        </div>

        <div class="container feature-box animate__animated animate__fadeInUp animate__delay-1s">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-item">
                        <i class="bi bi-shield-check fs-1 text-info"></i>
                        <h4 class="mt-3">Terverifikasi</h4>
                        <p class="small opacity-75">Persetujuan admin mutlak diperlukan untuk keamanan data.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <i class="bi bi-file-earmark-pdf fs-1 text-info"></i>
                        <h4 class="mt-3">Arsip Digital</h4>
                        <p class="small opacity-75">Simpan bukti fisik dalam format digital yang rapi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <i class="bi bi-clock-history fs-1 text-info"></i>
                        <h4 class="mt-3">Riwayat Log</h4>
                        <p class="small opacity-75">Pantau setiap aksi yang dilakukan oleh pengguna.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="wave-container">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C51.17,101.8,105.74,105,159.44,95.83c66-11.3,123.63-29.61,161.95-39.39Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

</body>
</html>