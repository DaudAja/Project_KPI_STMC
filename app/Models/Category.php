<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Daftarkan semua kolom yang bisa diisi
    protected $fillable = [
        'nama_kategori',
        'jenis',
        'sifat',
        'kode_kategori',
        'format_nomor'
    ];

    /**
     * Relasi ke Surat: Satu kategori memiliki banyak surat.
     */
    public function surats()
    {
        return $this->hasMany(Surat::class, 'category_id');
    }
}
