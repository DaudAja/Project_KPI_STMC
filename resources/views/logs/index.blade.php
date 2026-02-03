@extends('layouts.Master')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0 text-primary">Log Aktivitas Sistem</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Deskripsi</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allLogs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td><span class="badge bg-secondary">{{ $log->user->name }}</span></td>
                            <td><span class="text-primary fw-bold">{{ $log->aksi }}</span></td>
                            <td>{{ $log->deskripsi }}</td>
                            <td><small class="text-muted">{{ $log->ip_address }}</small></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $allLogs->links() }} </div>
        </div>
    </div>
</div>
@endsection
