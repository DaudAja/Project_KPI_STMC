<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | STMC Digital Klinik</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #0d6efd 0%, #18bc9c 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
            margin: 0;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px; /* Sedikit lebih lebar dari login */
            padding: 40px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }

        .btn-register {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-register:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .back-link {
            text-decoration: none;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="register-card animate__animated animate__fadeIn">
        <div class="text-center mb-4">
            <img src="{{ asset('Images/logoST.png') }}" alt="Logo" width="60" class="mb-3">
            <h4 class="fw-bold">Daftar Akun Baru</h4>
            <p class="text-muted small">Lengkapi data diri Anda untuk akses STMC</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2 small">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label small fw-semibold">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                    <input type="text" name="nama_lengkap" class="form-control border-start-0" placeholder="Contoh: Budi Santoso" required value="{{ old('nama_lengkap') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control border-start-0" placeholder="email@stmc.com" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Nomor Telepon</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-phone text-muted"></i></span>
                    <input type="text" name="no_telepon" class="form-control border-start-0" placeholder="0812..." required value="{{ old('no_telepon') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label small fw-semibold">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-register w-100 mb-3 shadow">
                DAFTAR SEKARANG
            </button>

            <div class="text-center">
                <p class="small text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Masuk</a></p>
                <hr>
                <a href="/" class="back-link"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
            </div>
        </form>
    </div>

</body>
</html>