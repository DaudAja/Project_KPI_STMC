<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'aksi', 'deskripsi', 'ip_address'];

    public static function record($aksi, $deskripsi)
    {
        self::create([
            'user_id' => Auth::id(),
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
            'ip_address' => Request::ip(),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

