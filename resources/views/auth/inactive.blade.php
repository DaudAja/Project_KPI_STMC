<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Dinonaktifkan | STMC Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .inactive-card { max-width: 500px; border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .icon-box { width: 80px; height: 80px; background: #fff2f2; color: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 20px; }
    </style>
</head>
<body>

<div class="container text-center">
    <div class="card inactive-card mx-auto p-4 p-md-5">
        <div class="card-body">
            <div class="icon-box">
                <i class="bi bi-slash-circle"></i>
            </div>

            <h3 class="fw-bold text-dark mb-3">Akun Dinonaktifkan</h3>

            <p class="text-muted mb-4">
                Maaf, <strong>{{ auth()->user()->nama_lengkap }}</strong>. <br>
                Akses Anda ke sistem STMC Digital telah dinonaktifkan oleh Administrator.
            </p>

            <div class="alert alert-danger border-0 small mb-4">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Silakan hubungi bagian IT atau Admin untuk informasi lebih lanjut mengenai status akun Anda.
            </div>

            <div class="d-grid gap-2">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger rounded-pill py-2 w-100">
                        <i class="bi bi-box-arrow-left me-2"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <p class="mt-4 text-muted small">&copy; {{ date('Y') }} STMC Digital Klinik</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
