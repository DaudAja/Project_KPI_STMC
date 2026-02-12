@extends('layouts.Master')

@section('content')
    <div class="container-fluid">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-primary">Log Aktivitas Sistem</h5>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Aksi</th>
                        <th>Detail Aktivitas</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $log->user->nama_lengkap ?? 'System' }}</strong></td>
                            <td>
                                {{-- Logika Warna Badge berdasarkan kolom Aksi --}}
                                @php
                                    $badgeColor = 'bg-secondary'; // Warna default (abu-abu)
                                    if (str_contains($log->aksi, 'Tambah')) {
                                        $badgeColor = 'bg-success';
                                    } // Hijau
                                    if (str_contains($log->aksi, 'Edit')) {
                                        $badgeColor = 'bg-primary';
                                    } // Biru
                                    if (str_contains($log->aksi, 'Hapus')) {
                                        $badgeColor = 'bg-danger';
                                    } // Merah
                                    if (str_contains($log->aksi, 'Login')) {
                                        $badgeColor = 'bg-info text-dark';
                                    } // Biru Muda
                                @endphp

                                <span class="badge {{ $badgeColor }}">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td><small>{{ $log->deskripsi }}</small></td>
                            <td><code class="text-muted">{{ $log->ip_address ?? '-' }}</code></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Jangan lupa pagination di bawah tabel --}}
            <div class="d-flex justify-content-center">
                {{ $logs->links() }}
            </div>

        </div>
    </div>
@endsection
