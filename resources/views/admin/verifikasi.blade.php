@extends('layouts.Master')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark">
                <i class="bi bi-people-fill me-2 text-primary"></i>Verifikasi Pengguna Baru
            </h4>
            <p class="text-muted">Kelola dan setujui pendaftaran pengguna untuk mengakses sistem.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold" style="width: 5%">No</th>
                            <th class="py-3 text-uppercase small fw-bold">Informasi User</th>
                            <th class="py-3 text-uppercase small fw-bold">Kontak</th>
                            <th class="py-3 text-uppercase small fw-bold">Role</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $user->nama_lengkap }}</div>
                                <div class="small text-muted">{{ $user->email }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border font-monospace">
                                    <i class="bi bi-telephone me-1"></i>{{ $user->no_telepon }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-info' }} bg-opacity-10 text-{{ $user->role == 'admin' ? 'danger' : 'info' }} px-3">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-check-circle me-1"></i> Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.reject', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="bi bi-x-circle me-1"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x display-4 mb-3 d-block"></i>
                                Tidak ada antrean verifikasi saat ini.
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
