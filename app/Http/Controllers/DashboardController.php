<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Surat Masuk (Menghitung melalui relasi kategori)
        $masukHariIni = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'masuk');
        })->whereDate('created_at', today())->count();

        // 2. Statistik Surat Keluar (Menghitung melalui relasi kategori)
        $keluarHariIni = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'keluar');
        })->whereDate('created_at', today())->count();

        // 3. Tambahan: Statistik Berdasarkan Sifat (Poin Plus KPI)
        $internalCount = Surat::whereHas('category', function($q) {
            $q->where('sifat', 'internal');
        })->count();

        $externalCount = Surat::whereHas('category', function($q) {
            $q->where('sifat', 'external');
        })->count();

        // 4. Ambil 5 Surat Terbaru dengan relasi kategorinya agar tidak lambat (Eager Loading)
        $suratTerbaru = Surat::with('category')->latest()->take(5)->get();

        // 5. Ambil data logs terbaru
        $logs = ActivityLog::with('user')->latest()->take(5)->get();

        // 6. Return ke view dengan semua data pendukung
        return view('dashboard', compact(
            'masukHariIni',
            'keluarHariIni',
            'internalCount',
            'externalCount',
            'suratTerbaru',
            'logs'
        ));
    }
}
