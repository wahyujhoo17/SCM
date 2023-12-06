<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelebihan_barang extends Model
{
    protected $table = 'kelebihan_barang';
    public $timestamps = false;
    use HasFactory;


    public function barang()
    {
        return $this->belongsToMany(barang_mentah::class, 'detail_barang_lebih','kelebihan_barang_id','barang_id')->withPivot('jumlah');
    }
}
