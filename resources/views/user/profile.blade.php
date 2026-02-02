@extends('layouts.Master')

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    {{-- Alert Notifikasi --}}
                    @if (session('success_profile'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            <i class="bi bi-check-circle me-2"></i> {{ session('success_profile') }}
                        </div>
                    @endif
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-person-circle me-2"></i>Profile</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label small fw-bold">NAMA LENGKAP</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->nama_lengkap }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">ALAMAT EMAIL</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">ROLE / JABATAN</label>
                                <input type="text" class="form-control" value="{{ $user->role }}" disabled>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Simpan Perubahan Profil</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    {{-- Alert Notifikasi --}}
                    @if (session('success_password'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            <i class="bi bi-check-circle me-2"></i> {{ session('success_password') }}
                        </div>
                    @endif
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-shield-lock me-2"></i>Keamanan Akun</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label small fw-bold">PASSWORD SAAT INI</label>
                                <input type="password" name="current_password" class="form-control"
                                    placeholder="Password Saat Ini" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">PASSWORD BARU</label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">KONFIRMASI PASSWORD BARU</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Konfirmasi Password Anda" required>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Update Password Keamanan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
