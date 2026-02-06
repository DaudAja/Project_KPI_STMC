@extends('layouts.Master')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-bold text-primary mb-3">Tambah Kategori Baru</h6>
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="small fw-bold">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control form-control-sm" placeholder="Contoh: Surat Tugas" required>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="small fw-bold">Instansi</label>
                            <input type="text" name="instansi" class="form-control form-control-sm" placeholder="STMC" required>
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold">Kode</label>
                            <input type="text" name="kode_kategori" class="form-control form-control-sm" placeholder="ST" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Pola Format Nomor</label>
                        <input type="text" name="format_nomor" class="form-control form-control-sm" value="{no}/{instansi}/{kode}/{bulan}/{tahun}" required>
                        <small class="text-muted" style="font-size: 10px;">Gunakan: {no}, {instansi}, {kode}, {bulan}, {tahun}</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm">Simpan Kategori</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <table class="table table-hover small">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Instansi</th>
                                <th>Kode</th>
                                <th>Format Template</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                            <tr>
                                <td>{{ $cat->nama_kategori }}</td>
                                <td><span class="badge bg-light text-dark">{{ $cat->instansi }}</span></td>
                                <td><span class="badge bg-info">{{ $cat->kode_kategori }}</span></td>
                                <td><code>{{ $cat->format_nomor }}</code></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
