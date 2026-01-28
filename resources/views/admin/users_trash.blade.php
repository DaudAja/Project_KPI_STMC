@extends('layouts.Master')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark"><i class="bi bi-trash3-fill me-2 text-danger"></i>Arsip User (Ditolak/Dihapus)</h4>
            <p class="text-muted">Daftar pengguna yang ditolak pendaftarannya atau dihapus aksesnya.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama & Email</th>
                            <th>No. Telepon</th>
                            <th>Tanggal Dihapus</th>
                            <th class="text-center">Aksi</th>
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
                            <td>{{ $user->no_telepon }}</td>
                            <td>{{ $user->deleted_at->format('d M Y, H:i') }}</td>
                            
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success px-3 rounded-pill">Restore</button>
                                    </form>

                                    <form action="{{ route('admin.users.force_delete', $user->id) }}" method="POST" onsubmit="return confirm('Hapus permanen? Data tidak bisa kembali!')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill">Hapus Permanen</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Tidak ada data di tempat sampah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
