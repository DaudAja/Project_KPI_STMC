@extends('layouts.Master')

@section('content')
{{-- p-0 memastikan tidak ada jarak antara konten dan tepi layar --}}
<div class="container-fluid p-0 animate__animated animate__fadeIn">
    <div class="row m-0"> {{-- m-0 menghilangkan margin negatif row --}}
        <div class="col-12 p-0"> {{-- col-12 tanpa padding agar benar-benar full --}}
            <div class="card border-0 shadow-none" style="min-height: 100vh; border-radius: 0;">
                {{-- Header Full Width --}}
                <div class="card-header bg-white py-4 px-4 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-file-earmark-plus me-2 text-primary"></i> Input Surat Baru
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Isi formulir di bawah ini secara lengkap untuk mengarsipkan surat.</p>
                </div>

                <div class="card-body p-4 p-md-5"> {{-- Memberikan padding internal agar teks tidak nempel sekali ke layar --}}
                    <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4"> {{-- g-4 memberikan jarak antar input yang lebih lega --}}

                            {{-- Jenis Arus Surat --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jenis Arus Surat</label>
                                <select id="jenis_surat" name="jenis_surat" class="form-select form-select-lg select-custom" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="masuk">Surat Masuk</option>
                                    <option value="keluar">Surat Keluar</option>
                                </select>
                            </div>

                            {{-- Kategori Surat --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori Surat</label>
                                <select id="category_id" name="category_id" class="form-select form-select-lg" disabled required>
                                    <option value="">-- Pilih Jenis Dahulu --</option>
                                </select>
                            </div>

                            {{-- Nomor Surat Otomatis --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Nomor Surat Otomatis</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light"></span>
                                    <input type="text" id="nomor_surat_display" class="form-control bg-light fw-bold" readonly placeholder="Nomor akan muncul otomatis...">
                                    <input type="hidden" name="nomor_surat" id="nomor_surat_hidden">
                                </div>
                            </div>

                            {{-- Perihal --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Perihal / Nama Surat</label>
                                <input type="text" name="nama_surat" class="form-control form-control-lg" placeholder="Contoh: Undangan Rapat Kurikulum" required>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="form-control form-control-lg" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required>
                            </div>

                            {{-- File Bukti --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Dokumen Bukti (PDF)</label>
                                <input type="file" name="foto_bukti" id="file_pdf" class="form-control form-control-lg @error('foto_bukti') is-invalid @enderror" accept=".pdf" required>
                                @error('foto_bukti')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Maks. 5MB</small>
                            </div>

                            {{-- Alert PDF --}}
                            <div class="col-12 d-none" id="pdf-alert">
                                <div class="alert alert-info py-3 shadow-sm mb-0">
                                    <i class="bi bi-file-earmark-pdf-fill me-2 fs-5"></i>
                                    <span id="pdf-name" class="fw-bold">File siap diunggah.</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <a href="/dashboard" class="btn btn-light btn-lg px-4 text-muted">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                                <i class="bi bi-check-circle me-2"></i> Simpan Data Surat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- JavaScript tetap sama seperti permintaanmu agar fungsi tidak berubah --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisSurat = document.getElementById('jenis_surat');
    const categorySelect = document.getElementById('category_id');
    const nomorDisplay = document.getElementById('nomor_surat_display');
    const nomorHidden = document.getElementById('nomor_surat_hidden');
    const fileInput = document.getElementById('file_pdf');
    const pdfAlert = document.getElementById('pdf-alert');

    // 1. Filter Kategori berdasarkan Jenis
    jenisSurat.addEventListener('change', async function() {
        const jenis = this.value;
        categorySelect.innerHTML = '<option value="">-- Loading... --</option>';
        categorySelect.disabled = true;
        nomorDisplay.value = '';

        if (!jenis) {
            categorySelect.innerHTML = '<option value="">-- Pilih Jenis Dahulu --</option>';
            return;
        }

        try {
            const response = await fetch(`/get-category-by-jenis/${jenis}`);
            const data = await response.json();

            categorySelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';
            data.forEach(cat => {
                const opt = new Option(`${cat.nama_kategori} (${cat.kode_kategori})`, cat.id);
                categorySelect.add(opt);
            });
            categorySelect.disabled = false;
        } catch (error) {
            console.error('Error fetching categories:', error);
            categorySelect.innerHTML = '<option value="">-- Gagal memuat data --</option>';
        }
    });

    // 2. Generate Nomor Surat
    categorySelect.addEventListener('change', async function() {
        const catId = this.value;
        if (!catId) return;

        nomorDisplay.value = 'Generating...';

        try {
            const response = await fetch(`/get-nomor-surat/${catId}`);
            const data = await response.json();

            nomorDisplay.value = data.nomor;
            nomorHidden.value = data.nomor;
        } catch (error) {
            console.error('Error generating number:', error);
            nomorDisplay.value = 'Gagal generate nomor';
        }
    });

    // 3. PDF File Preview
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            pdfAlert.classList.remove('d-none');
            document.getElementById('pdf-name').innerText = `File "${this.files[0].name}" terpilih.`;
        } else {
            pdfAlert.classList.add('d-none');
        }
    });
});
</script>
@endpush
