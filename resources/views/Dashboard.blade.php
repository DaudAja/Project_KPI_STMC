@extends('layouts.Master') 

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 text-white">
            <div class="card p-4 border-0 shadow-sm text-white animate__animated animate__fadeIn" style="background: var(--stmc-gradient); border-radius: 20px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1 ">Selamat Datang di STMC Digital</h2>
                        <p class="mb-0 opacity-75">Halo, {{ auth()->user()->nama_lengkap }}. Berikut ringkasan aktivitas hari ini.</p>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm border-start border-primary border-4">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-primary bg-opacity-10 rounded me-3"><i class="bi bi-envelope-download text-primary fs-3"></i></div>
                    <div>
                        <div class="text-muted small">Surat Masuk Hari Ini</div>
                        <h4 class="fw-bold mb-0">{{ $masukHariIni }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm border-start border-success border-4">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-success bg-opacity-10 rounded me-3"><i class="bi bi-envelope-upload text-success fs-3"></i></div>
                    <div>
                        <div class="text-muted small">Surat Keluar Hari Ini</div>
                        <h4 class="fw-bold mb-0">{{ $keluarHariIni }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm border-start border-info border-4">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-info bg-opacity-10 rounded me-3"><i class="bi bi-person-check text-info fs-3"></i></div>
                    <div>
                        <div class="text-muted small">Status Akun</div>
                        <h4 class="fw-bold mb-0 text-success">{{ ucfirst(auth()->user()->status) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">Aktivitas Surat Terbaru</h5>
                        <small class="text-muted">Data yang masuk ke sistem secara real-time</small>
                    </div>

                    <div class="text-end d-none d-md-block">
                        <div id="clock" class="fw-bold text-primary text-dark" style="font-size: 2rem; line-height: 1;">00:00:00</div>
                        <div class="small text-muted mt-1">
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">No. Surat</th>
                                    <th>Nama Surat</th>
                                    <th>Jenis</th>
                                    <th>Jam</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suratTerbaru as $surat)
                                <tr>
                                    <td class="ps-4 fw-medium text-primary">{{ $surat->nomor_surat }}</td>
                                    <td>{{ $surat->nama_surat }}</td>
                                    <td>
                                        @if($surat->jenis_surat == 'masuk')
                                            <span class="badge rounded-pill bg-info text-dark">Masuk</span>
                                        @else
                                            <span class="badge rounded-pill bg-success">Keluar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ optional($surat->created_at)->format('H:i') }} WITA</div>
                                        {{-- <div class="text-muted" style="font-size: 11px;">{{ $surat->created_at->translatedFormat('d F Y') }}</div> --}}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('surat.show', $surat->id) }}" class="btn btn-sm btn-outline-primary border-0 shadow-sm">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Belum ada surat yang diinput hari ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        
        const el = document.getElementById('clock');
        if (el) el.innerText = h + ":" + m + ":" + s;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection