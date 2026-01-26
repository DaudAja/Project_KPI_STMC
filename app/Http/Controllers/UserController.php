<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Ini fungsi Dashboard yang kita pindah ke sini
    public function dashboard()
    {
        $masukHariIni = Surat::where('jenis_surat', 'masuk')->whereDate('created_at', Carbon::today())->count();
        $keluarHariIni = Surat::where('jenis_surat', 'keluar')->whereDate('created_at', Carbon::today())->count();
        $suratTerbaru = Surat::whereDate('created_at', Carbon::today())->latest()->get();

        return view('dashboard', compact('masukHariIni', 'keluarHariIni', 'suratTerbaru'));
    }

    // Fungsi Profil
    public function profile()
    {
        return view('user.profile');
    }

    // Fungsi Verifikasi Admin (Hanya bisa dibuka Admin)
    public function verifikasi()
    {
        $users = User::where('status', 'pending')->get();
        return view('admin.verifikasi', compact('users'));
    }
    public function indexVerifikasi()
{
    // Cek apakah yang login adalah admin
    if (auth()->user()->status !== 'admin') {
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }

    $users = User::where('status', 'pending')->get();
    return view('admin.verifikasi', compact('users'));
}
}
