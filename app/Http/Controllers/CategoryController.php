<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'instansi'      => 'required',
            'kode_kategori' => 'required',
            'format_nomor'  => 'required', // Contoh: {no}/{instansi}/{kode}/{bulan}/{tahun}
        ]);

        $category = Category::create($request->all());

        // Catat di Log Aktivitas
        ActivityLog::record('Tambah Kategori', 'Menambahkan kategori baru: ' . $category->nama_kategori);

        return redirect()->back()->with('success', 'Kategori Berhasil Ditambah!');
    }

    public function getByJenis($jenis)
    {
        $category = Category::where('jenis', $jenis)->get();
        return response()->json($category);
    }
}
