@extends('layouts.Master')

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-plus me-2 text-primary"></i> Input
                            Surat Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">NOMOR SURAT</label>
                                    <input type="text" name="nomor_surat" class="form-control bg-light"
                                        value="{{ $nomorOtomatis }}" readonly>
                                    <small class="text-muted">Nomor surat dibuat otomatis oleh sistem.</small>
                                    @error('nomor_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-secondary">JENIS SURAT</label>
                                    <select name="jenis_surat" class="form-select" required>
                                        <option value="masuk" {{ old('jenis_surat') == 'masuk' ? 'selected' : '' }}>Surat
                                            Masuk</option>
                                        <option value="keluar" {{ old('jenis_surat') == 'keluar' ? 'selected' : '' }}>Surat
                                            Keluar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">NAMA / PERIHAL SURAT</label>
                                <input type="text" name="nama_surat" class="form-control"
                                    placeholder="Contoh: Undangan Rapat Koordinasi" required
                                    value="{{ old('nama_surat') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-secondary">TANGGAL SURAT</label>
                                    <input type="date" name="tanggal_surat" class="form-control" required
                                        value="{{ old('tanggal_surat', date('Y-m-d')) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-secondary">DOKUMEN BUKTI (WAJIB PDF)</label>
                                    <input type="file" name="foto_bukti"
                                        class="form-control @error('foto_bukti') is-invalid @enderror" accept=".pdf"
                                        required>
                                    @error('foto_bukti')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format file harus .pdf (Maks. 5MB)</small>
                                </div>

                                <div class="mb-4 text-center d-none" id="pdf-alert">
                                    <div class="alert alert-info small shadow-sm">
                                        <i class="bi bi-file-earmark-pdf-fill me-2"></i>
                                        <span id="pdf-name">File PDF siap diunggah.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 text-center d-none" id="preview-container">
                                <label class="d-block small fw-bold text-secondary mb-2 text-start">PREVIEW DOKUMEN:</label>
                                <img id="img-preview" class="img-fluid rounded shadow-sm border" style="max-height: 300px;">
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="/dashboard" class="text-decoration-none text-muted small"><i
                                        class="bi bi-arrow-left"></i> Batal</a>
                                <button type="submit" class="btn btn-primary px-5 rounded-pill shadow"
                                    style="background: var(--stmc-gradient); border: none;">
                                    <i class="bi bi-check-circle me-2"></i> SIMPAN DATA SURAT
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('input[name="foto_bukti"]').addEventListener('change', function(e) {
            const container = document.querySelector('#pdf-alert');
            // Pastikan elemen #pdf-alert ada sebelum mengubah class-nya
            if (container && this.files.length > 0) {
                container.classList.remove('d-none');

                // Opsional: Menampilkan nama file yang dipilih
                const fileName = this.files[0].name;
                container.querySelector('.alert').innerHTML =
                    `<i class="bi bi-file-earmark-pdf-fill me-2"></i> File <strong>${fileName}</strong> siap diunggah.`;
            }
        });
    </script>
@endsection
