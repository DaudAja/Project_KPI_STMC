<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | STMC Digital Klinik</title>
    
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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            padding: 40px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            border-color: #0d6efd;
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .back-link {
            text-decoration: none;
            font-size: 0.9rem;
            color: #666;
            transition: 0.3s;
        }

        .back-link:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>

    <div class="login-card animate__animated animate__zoomIn">
        <div class="text-center mb-4">
            <img src="{{ asset('Images/logoST.png') }}" alt="Logo" width="70" class="mb-3">
            <h4 class="fw-bold">Selamat Datang</h4>
            <p class="text-muted small">Silakan masuk ke akun STMC Anda</p>
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

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control border-start-0" placeholder="nama@stmc.com" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">
                MASUK SEKARANG
            </button>

            <div class="text-center">
                <p class="small text-muted">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Daftar</a></p>
                <hr>
                <a href="/" class="back-link"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
            </div>
        </form>
    </div>

</body>
</html>