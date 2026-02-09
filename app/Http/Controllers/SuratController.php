<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\ActivityLog;

class SuratController extends Controller
{
    // 1. Fungsi untuk dipanggil JavaScript saat memilih Sifat & Jenis
    public function getCategories($sifat, $jenis)
    {
        $categories = Category::where('sifat', $sifat)
            ->where('jenis', $jenis)
            ->get();

        return response()->json($categories);
    }

    // 2. Fungsi AJAX untuk mendapatkan nomor surat otomatis
    public function getNomorAjax($categoryId)
    {
        $nomor = $this->generateNomorSurat($categoryId);
        return response()->json(['nomor' => $nomor]);
    }

    // 3. Inti Logika Penomoran (Dinamis)
    private function generateNomorSurat($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $tahun = date('Y');
        $bulanDigit = date('m'); // FORMAT BULAN ANGKA (01, 02, dst)

        // Hitung urutan berdasarkan kategori tersebut di tahun ini
        $urutan = Surat::withTrashed()
            ->where('category_id', $categoryId)
            ->whereYear('created_at', $tahun)
            ->count() + 1;

        $no = str_pad($urutan, 3, '0', STR_PAD_LEFT);

        // Variabel pengganti untuk Placeholder di format_nomor
        $map = [
            '{no}'    => $no,
            '{bulan}' => $bulanDigit,
            '{tahun}' => $tahun,
        ];

        // Mengambil pola dari database (Contoh: {no}/Ext/ST/...)
        // lalu mengganti placeholder dengan data asli
        return str_replace(array_keys($map), array_values($map), $category->format_nomor);
    }

    // private function generateNomorSurat($jenis)
    // private function generateNomorSurat($categoryId)
    // {
    //     // 1. Ambil data kategori dari DB
    //     $category = Category::findOrFail($categoryId);

    //     // 2. Siapkan variabel pendukung
    //     $tahun = date('Y');
    //     $bulanRomawi = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
    //     $bulan = $bulanRomawi[date('n')];

    //     // 3. Hitung urutan berdasarkan category_id
    //     $urutan = Surat::withTrashed()
    //         ->where('category_id', $categoryId)
    //         ->whereYear('created_at', $tahun)
    //         ->count() + 1;

    //     $no = str_pad($urutan, 3, '0', STR_PAD_LEFT);

    //     // 4. PARSER: Mengganti placeholder {no}, {instansi}, dll dengan data asli
    //     $map = [
    //         '{no}'       => $no,
    //         '{instansi}' => $category->instansi,
    //         '{kode}'     => $category->kode_kategori,
    //         '{bulan}'    => $bulan,
    //         '{tahun}'    => $tahun,
    //     ];

    //     // Mengembalikan nomor surat sesuai format di database
    //     return str_replace(array_keys($map), array_values($map), $category->format_nomor);
    // }

    // AJAX Handler untuk mendapatkan nomor surat otomatis
    // public function getNomorAjax($categoryId)
    // {
    //     $nomor = $this->generateNomorSurat($categoryId);
    //     return response()->json(['nomor' => $nomor]);
    // }
    // {
    //     $tahun = date('Y');
    //     $bulanRomawi = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
    //     $bulan = $bulanRomawi[date('n')];

    //     // Menentukan kode berdasarkan jenis surat
    //     $kode = ($jenis == 'masuk') ? 'M' : 'K';

    //     // Menghitung urutan surat untuk tahun berjalan
    //     $urutan = Surat::withTrashed()
    //         ->where('jenis_surat', $jenis)// Filter berdasarkan jenis (masuk/keluar)
    //         ->whereYear('created_at', $tahun)
    //         ->count() + 1;

    //     // Format nomor urut dengan 3 digit
    //     $nomorUrut = str_pad($urutan, 3, '0', STR_PAD_LEFT);

    //     return "$nomorUrut/STMC/$kode/$bulan/$tahun";
    // }


    // 1. FUNGSI UNTUK MENAMPILKAN FORM INPUT
    public function input()
    {
        // Ambil semua kategori untuk ditampilkan di dropdown
        $category = Category::all();

        return view('surat.tambah', compact('category'));
    }
    // public function input(Request $request)
    // {
    //     // Ambil jenis dari URL (contoh: /input?jenis=masuk), default ke 'masuk'
    //     $jenis = $request->query('jenis', 'masuk');

    //     // Generate nomor otomatis untuk ditampilkan di form (sebagai preview)
    //     $nomorOtomatis = $this->generateNomorSurat($jenis);

    //     return view('surat.tambah', compact('nomorOtomatis', 'jenis'));
    // }

    // 2. FUNGSI UNTUK PROSES SIMPAN (POST)
    public function store(Request $request)
    {
        $request->validate([
            'category_id'   => 'required|exists:categories,id', // Validasi kategori
            'nama_surat'    => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'foto_bukti'    => 'required|file|mimes:pdf|max:5120',
            'nomor_surat'   => 'required|unique:surats,nomor_surat',
        ]);

        // Proses upload file
        $nama_file = null;
        if ($request->hasFile('foto_bukti')) {
            $path = $request->file('foto_bukti')->store('surat', 'public');
            $nama_file = basename($path);
        }

        // Simpan Data
        $surat = Surat::create([
            'user_id'       => Auth::id(),
            'category_id'   => $request->category_id,
            'nomor_surat'   => $request->nomor_surat,
            'nama_surat'    => $request->nama_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'foto_bukti'    => $nama_file,
        ]);

        // Tambahkan Log Aktivitas (Opsional tapi sangat disarankan)
        ActivityLog::record('Tambah Surat', 'Menambahkan surat nomor: ' . $surat->nomor_surat);

        return redirect()->route('dashboard')->with('success', 'Surat berhasil diarsipkan!');
    }
    // public function store(Request $request)
    // {
    //     // 1. Validasi Input
    //     $request->validate([
    //         'nomor_surat'   => 'required|string|unique:surats,nomor_surat',
    //         'nama_surat'    => 'required|string|max:255',
    //         'jenis_surat'   => 'required|in:masuk,keluar',
    //         'tanggal_surat' => 'required|date',
    //         'foto_bukti'    => 'required|file|mimes:pdf|max:5120',
    //     ]);

    //     // 2. Proses upload file
    //     $nama_file = null;
    //     if ($request->hasFile('foto_bukti')) {
    //         $path = $request->file('foto_bukti')->store('surat', 'public');
    //         $nama_file = basename($path);
    //     }

    //     // 3. Generate Nomor Surat Final (Tepat sebelum simpan)
    //     // Gunakan withTrashed() di dalam fungsi generateNomorSurat nanti
    //     // $nomorFinal = $this->generateNomorSurat($request->jenis_surat);

    //     // 4. Simpan ke database
    //     $surat = Surat::create([
    //         'user_id'       => Auth::id(),
    //         // 'nomor_surat'   => $nomorFinal,
    //         'nomor_surat'   => $request->nomor_surat,
    //         'jenis_surat'   => $request->jenis_surat,
    //         'nama_surat'    => $request->nama_surat,
    //         'tanggal_surat' => $request->tanggal_surat,
    //         'foto_bukti'    => $nama_file,
    //     ]);

    //     // 5. (Opsional) Catat ke Log Aktivitas di sini nanti
    //     \App\Models\ActivityLog::record(
    //         'Input Surat',
    //         'Berhasil mengarsipkan surat baru dengan nomor: ' . $surat->nomor_surat
    //     );
    //     return redirect()->route('dashboard')->with('success', 'Arsip Berhasil!');
    // }

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

    // FUNGSI UNTUK SURAT MASUK
    public function Masuk()
    {
        // Gunakan whereHas untuk memfilter berdasarkan kolom 'jenis' di tabel 'categories'
        $surat = Surat::whereHas('category', function ($q) {
            $q->where('jenis', 'masuk');
        })->latest()->paginate(10);

        return view('surat.masuk', compact('surat'));
    }

    // FUNGSI UNTUK SURAT KELUAR
    public function Keluar()
    {
        // Gunakan whereHas untuk memfilter berdasarkan kolom 'jenis' di tabel 'categories'
        $surat = Surat::whereHas('category', function ($q) {
            $q->where('jenis', 'keluar');
        })->latest()->paginate(10);

        return view('surat.keluar', compact('surat'));
    }
}
