<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class UserController extends Controller
{
    // Ini fungsi Dashboard yang kita pindah ke sini
    public function dashboard()
    {
        // 1. Hitung Surat Masuk Hari Ini via Relasi
        $masukHariIni = Surat::whereHas('category', function ($q) {
            $q->where('jenis', 'masuk');
        })->whereDate('created_at', today())->count();

        // 2. Hitung Surat Keluar Hari Ini via Relasi
        $keluarHariIni = Surat::whereHas('category', function ($q) {
            $q->where('jenis', 'keluar');
        })->whereDate('created_at', today())->count();

        // 3. AMBIL DATA INI (Yang tadi menyebabkan error)
        $internalCount = Surat::whereHas('category', function ($q) {
            $q->where('sifat', 'internal');
        })->count();

        $externalCount = Surat::whereHas('category', function ($q) {
            $q->where('sifat', 'external');
        })->count();

        // 4. Ambil Surat Terbaru dengan Eager Loading 'category'
        $suratTerbaru = Surat::with('category')->latest()->take(10)->get();

        // 5. Ambil data logs aktivitas terbaru
        $logs = ActivityLog::with('user')->latest()->take(5)->get();

        // 6. Pastikan semua variabel dimasukkan ke dalam compact()
        return view('dashboard', compact(
            'masukHariIni',
            'keluarHariIni',
            'internalCount', // <-- Variabel ini yang dicari View
            'externalCount', // <-- Ini juga jangan lupa
            'suratTerbaru',
            'logs'
        ));
    }

    // Fungsi Profil
    public function profile()
    {
        return view('user.profile', [
            'user' => Auth::user()
        ]);
    }

    // Fungsi Update Profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // dd(gettype($user), is_object($user) ? get_class($user) : null, $user);
        $user->update($request->only('name', 'email'));
        return redirect()->back()->with('success_profile', 'Profil berhasil diperbarui!');
    }

    // Fungsi Update Password
    public function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        return redirect()->back()->with('success_password', 'Password berhasil diperbarui.');
    }

    // Fungsi Verifikasi Admin (Hanya bisa dibuka Admin)
    public function verifikasi()
    {
        $users = User::where('status', 'pending')->get();
        return view('admin.verifikasi', compact('users'));
    }

    // Fungsi Nonaktifkan Akses User
    public function deactivate(User $user)
    {
        $user->update(['status' => 'inactive']);
        return redirect()->back()->with('success', 'Akses user ' . $user->nama_lengkap . ' telah dinonaktifkan.');
    }

    // Fungsi Aktivasi Ulang Akun
    public function activate(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect()->back()->with('success', 'Akun ' . $user->nama_lengkap . ' telah diaktifkan kembali.');
    }

    // Fungsi Daftar User (Kecuali Diri Sendiri dan Pending)
    public function userList()
    {
        // Kita ambil semua user kecuali diri sendiri dan yang masih pending
        $users = User::where('id', '!=', Auth::user()->id)
            ->whereIn('status', ['active', 'inactive'])
            ->get();

        return view('admin.users_list', compact('users'));
    }

    // Fungsi Setujui User (Hanya bisa dibuka Admin)
    public function approve(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect()->back()->with('success', 'User ' . $user->nama_lengkap . ' berhasil disetujui.');
    }

    public function reject(User $user)
    {
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

    // Menampilkan daftar user yang telah di-softdelete
    public function trash()
    {
        // onlyTrashed() mengambil data yang kolom deleted_at nya TIDAK NULL
        $users = User::onlyTrashed()->get();
        return view('admin.users_trash', compact('users'));
    }

    // Mengembalikan user yang terhapus
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.index')->with('success', 'User ' . $user->nama_lengkap . ' berhasil dikembalikan.');
    }

    // Menghapus permanen dari database
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->back()->with('success', 'User dihapus selamanya dari sistem.');
    }
}
