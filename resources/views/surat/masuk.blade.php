@extends('layouts.Master')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Daftar Surat Masuk</h4>
        </div>

        {{-- Navigasi Tab --}}
        <div class="row mb-4">
            <div class="col-12">
                {{-- bg-white untuk latar belakang, p-2 untuk jarak dalam --}}
                <ul class="nav nav-pills p-2 bg- shadow-sm rounded-pill d-inline-flex" id="pills-tab" role="tablist"
                    style="border: 1px solid #e9ecef;">

                    {{-- TAB INTERNAL --}}
                    <li class="nav-item" role="presentation">
                        {{-- Kita pakai 'text-success' agar tulisan default-nya hijau --}}
                        <button class="nav-link active rounded-pill px-4 fw-bold text-warning" id="pills-internal-tab"
                            data-bs-toggle="pill" data-bs-target="#pills-internal" type="button" role="tab">
                            <i class="bi bi-building me-2"></i> INTERNAL
                            <span
                                class="badge rounded-pill bg-warning text-white ms-1 shadow-sm">{{ $internal->count() }}</span>
                        </button>
                    </li>

                    {{-- TAB EKSTERNAL --}}
                    <li class="nav-item" role="presentation">
                        {{-- 'text-success' memastikan tulisan EKSTERNAL berwarna hijau saat tidak aktif --}}
                        <button class="nav-link rounded-pill px-4 fw-bold text-success" id="pills-external-tab"
                            data-bs-toggle="pill" data-bs-target="#pills-external" type="button" role="tab">
                            <i class="bi bi-globe me-2"></i> EKSTERNAL
                            <span
                                class="badge rounded-pill bg-success text-white ms-1 shadow-sm">{{ $external->count() }}</span>
                        </button>
                    </li>

                </ul>
            </div>
        </div>
        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show active" id="pills-internal" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @include('surat.partials.table_masuk', ['data' => $internal, 'color' => 'primary'])
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-external" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @include('surat.partials.table_masuk', ['data' => $external, 'color' => 'success'])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
