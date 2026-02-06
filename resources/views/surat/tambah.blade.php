@extends('layouts.Master')

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-plus me-2 text-primary"></i> Input
                            Surat Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jenis Arus Surat</label>
                                <select id="jenis_surat" name="jenis_surat" class="form-select" onchange="filterKategori()"
                                    required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="masuk">Surat Masuk</option>
                                    <option value="keluar">Surat Keluar</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori Surat</label>
                                <select id="category_id" name="category_id" class="form-select" onchange="generateNomor()"
                                    disabled required>
                                    <option value="">-- Pilih Jenis Dahulu --</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nomor Surat Otomatis</label>
                                <div class="input-group">
                                    <input type="text" id="nomor_surat_display" class="form-control bg-light" readonly
                                        placeholder="Nomor akan muncul otomatis...">
                                    <input type="hidden" name="nomor_surat" id="nomor_surat_hidden">
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Perihal / Nama Surat</label>
                                <input type="text" name="nama_surat" class="form-control" required>
                            </div>

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
                                    class="form-control @error('foto_bukti') is-invalid @enderror" accept=".pdf" required>
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
<script>
    // Fungsi 1: Ambil Kategori berdasarkan Jenis (Masuk/Keluar)
    function filterKategori() {
        const jenis = document.getElementById('jenis_surat').value;
        const catSelect = document.getElementById('categories_id');
        const nomorInput = document.getElementById('nomor_surat_display');

        // Reset dropdown kategori dan nomor
        catSelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';
        nomorInput.value = '';

        if (!jenis) {
            catSelect.disabled = true;
            return;
        }

        // Panggil Route AJAX yang akan kita buat
        fetch(`/get-categories-by-jenis/${jenis}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(category => {
                    let option = document.createElement('option');
                    option.value = category.id;
                    option.text = `${category.nama_kategori} (${category.kode_kategori})`;
                    catSelect.appendChild(option);
                });
                catSelect.disabled = false;
            })
            .catch(error => console.error('Error:', error));
    }

    // Fungsi 2: Ambil Nomor Surat berdasarkan Kategori yang dipilih
    function generateNomor() {
        const categoryId = document.getElementById('categories_id').value;
        const nomorDisplay = document.getElementById('nomor_surat_display');
        const nomorHidden = document.getElementById('nomor_surat_hidden');

        if (!categoryId) {
            nomorDisplay.value = '';
            return;
        }

        fetch(`/get-nomor-surat/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                nomorDisplay.value = data.nomor;
                nomorHidden.value = data.nomor;
            })
            .catch(error => console.error('Error:', error));
    }
</script>
