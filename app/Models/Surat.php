<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    'user_id',
    'categories_id', 
    'nomor_surat',
    'nama_surat',
    'jenis_surat',
    'tanggal_surat',
    'foto_bukti'
];

    /**
     * Relasi ke Category: Setiap surat milik satu kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    /**
     * Relasi ke User: Setiap surat diinput oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
