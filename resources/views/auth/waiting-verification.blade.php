<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Verifikasi | STMC Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .verification-card {
            max-width: 500px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .icon-box {
            width: 80px;
            height: 80px;
            background: #fff3cd;
            color: #ffc107;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
        }
    </style>st
</head>
<body>

<div class="container text-center">
    <div class="card verification-card mx-auto p-4 p-md-5">
        <div class="card-body">
            <div class="icon-box">
                <i class="bi bi-clock-history"></i>
            </div>

            <h3 class="fw-bold text-dark mb-3">Akun Menunggu Verifikasi</h3>

            <p class="text-muted mb-4">
                Halo, <strong>{{ auth()->user()->nama_lengkap }}</strong>. <br>
                Pendaftaran Anda berhasil dikirim! Saat ini administrator kami sedang melakukan pengecekan data Anda.
            </p>

            <div class="alert alert-info border-0 small mb-4" style="background: #e7f1ff; color: #084298;">
                <i class="bi bi-info-circle me-2"></i>
                Akses ke dashboard akan terbuka otomatis setelah akun Anda dinyatakan <strong>Aktif</strong> oleh Admin.
            </div>

            <div class="d-grid gap-2">
                {{-- <a href="https://wa.me/628123456789" target="_blank" class="btn btn-success rounded-pill py-2">
                    <i class="bi bi-whatsapp me-2"></i> Hubungi Admin
                </a> --}}

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link text-muted text-decoration-none small">
                        <i class="bi bi-box-arrow-left me-1"></i> Keluar dari Akun
                    </button>
                </form>
            </div>
        </div>
    </div>

    <p class="mt-4 text-muted small">&copy; {{ date('Y') }} STMC Digital Klinik Management</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
