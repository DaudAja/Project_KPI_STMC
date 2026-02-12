<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Ambil semua log aktivitas beserta relasi user
        $logs = ActivityLog::with('user')->latest()->paginate(15);

        // Kirim data log ke view
        return view('logs.index', compact('logs'));
    }
}
