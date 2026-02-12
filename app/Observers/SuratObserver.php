<?php

namespace App\Observers;

use App\Models\Surat;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SuratObserver
{
    /**
     * Handle the Surat "created" event.
     */
    public function created(Surat $surat): void
    {
        // dd('Observer berhasil terpanggil! Data surat: ' . $surat->nama_surat);
        $sifat = ucfirst($surat->category->sifat ?? '-');
        $jenis = ucfirst($surat->category->jenis ?? '-');

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Tambah Surat',
            'deskripsi' => "Menambahkan Surat $jenis ($sifat) | Nomor: {$surat->nomor_surat} | Judul: {$surat->nama_surat}",
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Surat "updated" event.
     */
    public function updated(Surat $surat): void
    {
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'Edit Surat',
            'deskripsi'  => "Mengubah detail surat nomor: {$surat->nomor_surat}",
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Surat "deleted" event.
     */
    public function deleted(Surat $surat): void
    {
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'Hapus Surat',
            'deskripsi'  => "Menghapus surat nomor: {$surat->nomor_surat}",
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Surat "restored" event.
     */
    public function restored(Surat $surat): void
    {
        //
    }

    /**
     * Handle the Surat "force deleted" event.
     */
    public function forceDeleted(Surat $surat): void
    {
        //
    }
}
