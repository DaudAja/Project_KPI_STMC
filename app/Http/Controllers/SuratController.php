<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratController extends Controller
{
    // 1. FUNGSI UNTUK MENAMPILKAN HALAMAN (GET)
    public function input()
    {
        return view('surat.tambah');
    }

    // 2. FUNGSI UNTUK PROSES SIMPAN (POST)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat'   => 'required|unique:surats,nomor_surat',
            'nama_surat'    => 'required|string|max:255',
            'jenis_surat'   => 'required|in:masuk,keluar',
            'tanggal_surat' => 'required|date',
            'foto_bukti'    => 'required|file|mimes:pdf|max:5120',
        ]);

        $validated['user_id'] = auth()->id();
        if ($request->hasFile('foto_bukti')) {
            $path = $request->file('foto_bukti')->store('arsip_pdf', 'public');
            $validated['foto_bukti'] = $path;
        }

        Surat::create($validated);

        return redirect()->route('dashboard')->with('success', 'Dokumen PDF berhasil diarsipkan!');
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
        $surat = Surat::where('jenis_surat', 'masuk')->latest()->paginate(10);
        return view('surat.masuk', compact('surat'));
    }
    public function keluar()
{
    // Mengambil data khusus surat keluar dengan pagination
    $surat = \App\Models\Surat::where('jenis_surat', 'keluar')->latest()->paginate(10);

    return view('surat.keluar', compact('surat'));
}
}
