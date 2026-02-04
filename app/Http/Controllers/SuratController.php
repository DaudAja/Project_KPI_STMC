<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SuratController extends Controller
{
    private function generateNomorSurat($jenis)
    {
        $tahun = date('Y');
        $bulanRomawi = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        $bulan = $bulanRomawi[date('n')];

        // Menentukan kode berdasarkan jenis surat
        $kode = ($jenis == 'masuk') ? 'M' : 'K';

        // Menghitung urutan surat untuk tahun berjalan
        $urutan = Surat::withTrashed()
            ->where('jenis_surat', $jenis)// Filter berdasarkan jenis (masuk/keluar)
            ->whereYear('created_at', $tahun)
            ->count() + 1;

        // Format nomor urut dengan 3 digit
        $nomorUrut = str_pad($urutan, 3, '0', STR_PAD_LEFT);

        return "$nomorUrut/STMC/$kode/$bulan/$tahun";
    }

    // 1. FUNGSI UNTUK MENAMPILKAN FORM INPUT
    public function input(Request $request)
    {
        // Ambil jenis dari URL (contoh: /input?jenis=masuk), default ke 'masuk'
        $jenis = $request->query('jenis', 'masuk');

        // Generate nomor otomatis untuk ditampilkan di form (sebagai preview)
        $nomorOtomatis = $this->generateNomorSurat($jenis);

        return view('surat.tambah', compact('nomorOtomatis', 'jenis'));
    }

    // 2. FUNGSI UNTUK PROSES SIMPAN (POST)
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nomor_surat'   => 'required|string|unique:surats,nomor_surat',
            'nama_surat'    => 'required|string|max:255',
            'jenis_surat'   => 'required|in:masuk,keluar',
            'tanggal_surat' => 'required|date',
            'foto_bukti'    => 'required|file|mimes:pdf|max:5120',
        ]);

        // 2. Proses upload file
        $nama_file = null;
        if ($request->hasFile('foto_bukti')) {
            $path = $request->file('foto_bukti')->store('surat', 'public');
            $nama_file = basename($path);
        }

        // 3. Generate Nomor Surat Final (Tepat sebelum simpan)
        // Gunakan withTrashed() di dalam fungsi generateNomorSurat nanti
        // $nomorFinal = $this->generateNomorSurat($request->jenis_surat);

        // 4. Simpan ke database
        $surat = Surat::create([
            'user_id'       => Auth::id(),
            // 'nomor_surat'   => $nomorFinal,
            'nomor_surat'   => $request->nomor_surat,
            'jenis_surat'   => $request->jenis_surat,
            'nama_surat'    => $request->nama_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'foto_bukti'    => $nama_file,
        ]);

        // 5. (Opsional) Catat ke Log Aktivitas di sini nanti
        \App\Models\ActivityLog::record(
            'Input Surat',
            'Berhasil mengarsipkan surat baru dengan nomor: ' . $surat->nomor_surat
        );
        return redirect()->route('dashboard')->with('success', 'Arsip Berhasil!');
    }

    public function show(Surat $surat)
    {
        // Memastikan data user ikut dipanggil
        $surat->load('user');
        return view('surat.detail', compact('surat'));
    }
    public function destroy(Surat $surat)
    {
        // 1. Hapus file fisik dari storage public
        if ($surat->foto_bukti && Storage::disk('public')->exists($surat->foto_bukti)) {
            Storage::disk('public')->delete($surat->foto_bukti);
        }

        // 2. Hapus data dari database
        $surat->delete();
        return redirect()->route('dashboard')->with('success', 'Arsip surat berhasil dihapus selamanya.');
    }
    public function masuk()
    {
        // Mengambil data khusus surat masuk dengan pagination
        $surat = Surat::where('jenis_surat', 'masuk')->latest()->paginate(10);
        return view('surat.masuk', compact('surat'));
    }
    public function keluar()
    {
        // Mengambil data khusus surat keluar dengan pagination
        $surat = Surat::where('jenis_surat', 'keluar')->latest()->paginate(10);

        return view('surat.keluar', compact('surat'));
    }
}
