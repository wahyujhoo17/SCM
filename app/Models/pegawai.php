<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    protected $table = 'users';
    // public $timestamps = false;
    use HasFactory;

    public function jabatan()
    {
        return $this->belongsTo(jabatan::class, 'jabatan_id');
    }
}
