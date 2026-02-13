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

    // 1. FUNGSI UNTUK MENAMPILKAN FORM INPUT
    public function input()
    {
        // Ambil semua kategori untuk ditampilkan di dropdown
        $category = Category::all();

        return view('surat.tambah', compact('category'));
    }

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

        return redirect()->route('dashboard')->with('success', 'Surat berhasil diarsipkan!');
    }

    // 3. FUNGSI UNTUK MENAMPILKAN DETAIL SURAT
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
    public function Masuk(Request $request)
    {
        $search = $request->get('search');

        // Query Dasar
        $baseQuery = function ($sifat) use ($search) {
            return Surat::with('category', 'user')
                ->whereHas('category', function ($q) use ($sifat) {
                    $q->where('jenis', 'masuk')->where('sifat', $sifat);
                })
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($sq) use ($search) {
                        $sq->where('nomor_surat', 'LIKE', "%$search%")
                            ->orWhere('nama_surat', 'LIKE', "%$search%");
                    });
                });
        };

        $internal = $baseQuery('internal')->latest()->get();
        $external = $baseQuery('external')->latest()->get();

        return view('surat.masuk', compact('internal', 'external'));
    }

    // FUNGSI UNTUK SURAT KELUAR
    public function Keluar(request $request)
    {
        $search = $request->get('search');

        // Query Dasar
        $baseQuery = function ($sifat) use ($search) {
            return Surat::with('category', 'user')
                ->whereHas('category', function ($q) use ($sifat) {
                    $q->where('jenis', 'keluar')->where('sifat', $sifat);
                })
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($sq) use ($search) {
                        $sq->where('nomor_surat', 'LIKE', "%$search%")
                            ->orWhere('nama_surat', 'LIKE', "%$search%");
                    });
                });
        };

        $internal = $baseQuery('internal')->latest()->get();
        $external = $baseQuery('external')->latest()->get();

        return view('surat.keluar', compact('internal', 'external'));
    }


    public function download($id)
    {
        $surat = Surat::findOrFail($id);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Download Surat',
            'deskripsi' => "Mendownload file surat dengan nomor: {$surat->nomor_surat}",
            'ip_address' => request()->ip(),
        ]);

        if (Storage::exists($surat)) {
            return Storage::download($surat, $surat->foto_bukti);
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    }
}
