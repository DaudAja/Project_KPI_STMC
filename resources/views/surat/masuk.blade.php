@extends('layouts.Master')

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row mb-4">
            <div class="col-12">
                  <div class="card p-4 border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #2478ef, #1737c3); border-radius: 20px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Arsip Surat Masuk</h2>
                            <p class="mb-0 opacity-75">Daftar seluruh dokumen masuk klinik STMC.</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-circle">
                            <i class="bi bi-envelope-download fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">No. Surat</th>
                                <th>Nama Surat</th>
                                <th>Tanggal Masuk</th>
                                <th>Oleh</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surat as $s)
                                <tr>
                                    <td class="ps-4 fw-medium text-primary">{{ $s->nomor_surat }}</td>
                                    <td>{{ $s->nama_surat }}</td>
                                    <td>{{ $s->tanggal_surat ? \Carbon\Carbon::parse($s->tanggal_surat)->translatedFormat('d F Y') : '-' }}
                                    </td>
                                    <td><small class="text-muted">{{ $s->user->nama_lengkap ?? 'Admin' }}</small></td>
                                    <td class="text-center">
                                            <a href="{{ asset('storage/surat/' . $s->foto_bukti) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary border-0">
                                                <i class="bi bi-file-earmark-pdf-fill"></i> Buka
                                            </a>

                                            <a href="{{ route('surat.show', $s->id) }}"
                                                class="btn btn-sm btn-outline-primary border-0">
                                                <i class="bi bi-eye-fill"></i> Detail
                                            </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada arsip surat masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $surat->links() }} {{-- Untuk navigasi halaman (pagination) --}}
            </div>
        </div>
    </div>
@endsection
