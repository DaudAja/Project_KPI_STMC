@extends('layouts.Master')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark">
                <i class="bi bi-person-gear me-2 text-primary"></i>Manajemen Pengguna
            </h4>
            <p class="text-muted">Pantau pengguna aktif dan kelola hak akses mereka ke sistem STMC.</p>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold" style="width: 5%">No</th>
                            <th class="py-3 text-uppercase small fw-bold">Profil Pengguna</th>
                            <th class="py-3 text-uppercase small fw-bold">Kontak</th>
                            <th class="py-3 text-uppercase small fw-bold">Status</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->nama_lengkap }}</div>
                                        <div class="small text-muted">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-normal">
                                    <i class="bi bi-telephone me-1 text-primary"></i>{{ $user->no_telepon }}
                                </span>
                            </td>
                            <td>
                                @if($user->status == 'active')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">
                                        <i class="bi bi-patch-check-fill me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 rounded-pill">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol untuk User Aktif --}}
                                    @if($user->status == 'active')
                                        <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" onsubmit="return confirm('Nonaktifkan akses user ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                <i class="bi bi-person-x me-1"></i> Nonaktifkan
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol untuk User Nonaktif --}}
                                    @if($user->status == 'inactive')
                                        <form action="{{ route('admin.users.activate', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                                <i class="bi bi-person-check me-1"></i> Aktifkan Kembali
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Opsi Hapus Permanen --}}
                                    {{-- <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-muted p-0 ms-2" title="Hapus Akun">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/no-messages.svg" alt="Empty" style="width: 150px;">
                                <p class="text-muted mt-3">Tidak ada data pengguna yang tersedia.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
