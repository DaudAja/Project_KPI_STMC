@extends('layouts.Master')

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Detail Arsip Dokumen</h4>
                <p class="text-muted small mb-0">Manajemen Dokumen Digital STMC</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-light border shadow-sm rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="p-3 bg-primary bg-opacity-10 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-file-earmark-pdf text-primary fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Informasi Surat</h5>
                            <span
                                class="badge {{ $surat->jenis_surat == 'masuk' ? 'bg-info text-dark' : 'bg-success' }} rounded-pill px-3">
                                Surat {{ ucfirst($surat->jenis_surat) }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted d-block text-uppercase fw-bold" style="font-size: 10px;">Nomor
                                Surat</label>
                            <p class="fw-bold text-dark">{{ $surat->nomor_surat }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted d-block text-uppercase fw-bold" style="font-size: 10px;">Perihal
                                Medis / Nama Surat</label>
                            <p class="fw-bold text-dark">{{ $surat->nama_surat }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted d-block text-uppercase fw-bold" style="font-size: 10px;">Tanggal
                                Surat</label>
                            <p class="fw-bold text-dark">
                                @php
                                    try {
                                        $tgl = \Carbon\Carbon::parse($surat->tanggal_surat);
                                        echo $tgl->translatedFormat('d F Y');
                                    } catch (\Exception $e) {
                                        echo $surat->tanggal_surat ?? '-';
                                    }
                                @endphp
                            </p>
                        </div>

                        <hr class="my-4">

                        <div class="mb-4">
                            <label class="small text-muted d-block text-uppercase fw-bold" style="font-size: 10px;">Diinput
                                Oleh</label>
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-light rounded-circle me-2"><i class="bi bi-person text-secondary"></i>
                                </div>
                                <div>
                                    <p class="fw-bold text-primary mb-0" style="font-size: 14px;">
                                        {{ $surat->user->nama_lengkap ?? 'Administrator' }}</p>
                                    <small class="text-muted" style="font-size: 11px;">
                                        {{ $surat->created_at?->format('d/m/Y H:i') ?? '-' }} WITA
                                    </small>
                                </div>
                            </div>
                        </div>
                        <a href="{{ asset('storage/surat/' . $surat->foto_bukti) }}" target="_blank"
                            class="btn btn-outline-primary w-100 rounded-pill mb-2">
                            <i class="bi bi-box-arrow-up-right me-2"></i> Buka di Tab Baru
                        </a>
                        <a href="{{ asset('storage/surat/' . $surat->foto_bukti) }}" download
                            class="btn btn-primary w-100 rounded-pill shadow-sm">
                            <i class="bi bi-download me-2"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                {{-- Card dibuat dengan tinggi dinamis 85% dari tinggi layar (85vh) --}}
                <div class="card border-0 shadow-sm overflow-hidden"
                    style="border-radius: 15px; height: 85vh; display: flex; flex-direction: column;">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-eye me-2 text-primary"></i> Pratinjau Dokumen
                        </h6>
                        <div class="d-flex gap-2">
                            <span
                                class="badge bg-light text-primary border">{{ strtoupper($surat->category->sifat) }}</span>
                            <small class="text-muted">Digital Scanner STMC</small>
                        </div>
                    </div>

                    {{-- Body card akan mengisi sisa ruang yang tersedia --}}
                    <div class="card-body p-0" style="flex: 1; position: relative;">
                        @if ($surat->foto_bukti)
                            {{-- #view=FitH memastikan PDF otomatis zoom menyesuaikan lebar layar --}}
                            <iframe src="{{ asset('storage/surat/' . $surat->foto_bukti) }}#view=FitH" width="100%"
                                height="100%" style="position: absolute; top: 0; left: 0; border: none;">
                            </iframe>
                        @else
                            <div
                                class="h-100 d-flex flex-column align-items-center justify-content-center text-secondary bg-light">
                                <i class="bi bi-file-earmark-x display-1 opacity-25"></i>
                                <p class="mt-3 fw-bold">Dokumen tidak ditemukan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
