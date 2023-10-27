<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perputaran_barang extends Model
{
    protected $table = 'perputaran_barang';
    public $timestamps = false;
    use HasFactory;

    public function barang()
    {
        return $this->belongsToMany(barang_mentah::class ,'barang_has_perputaran_barang','perputaran_barang_id','barang_id')->withPivot('jumlah');
    }
}
