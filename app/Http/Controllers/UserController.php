<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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

    // Fungsi Setujui User (Hanya bisa dibuka Admin)
    public function approve(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect()->back()->with('success', 'User ' . $user->nama_lengkap . ' berhasil disetujui.');
    }

    public function reject(User $user)
    {
        // Kamu bisa menghapusnya (SoftDelete sesuai Model kamu) atau mengubah status jadi inactive
        $user->delete();
        return redirect()->back()->with('error', 'Pendaftaran user telah ditolak/dihapus.');
    }

    public function indexVerifikasi()
    {
        // Cek apakah yang login adalah admin
        if (Auth::user()->status !== 'admin') {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $users = User::where('status', 'pending')->get();
        return view('admin.verifikasi', compact('users'));
    }
}
