<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Surat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = ['tanggal_surat' => 'date'];

public function user() {
    return $this->belongsTo(User::class);
}

}
