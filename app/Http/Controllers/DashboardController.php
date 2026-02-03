<?php
namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\ActivityLog; // 1. Pastikan Model di-import
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data statistik yang sudah ada
        $masukHariIni = Surat::where('jenis_surat', 'masuk')->whereDate('created_at', today())->count();
        $keluarHariIni = Surat::where('jenis_surat', 'keluar')->whereDate('created_at', today())->count();
        $suratTerbaru = Surat::latest()->take(5)->get();

        // 2. Ambil data logs terbaru
        $logs = ActivityLog::with('user')->latest()->take(5)->get();

        // 3. Masukkan $logs ke dalam compact
        return view('dashboard', compact(
            'masukHariIni',
            'keluarHariIni',
            'suratTerbaru',
            'logs'
        ));
    }
}
