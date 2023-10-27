<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gudang extends Model
{   
    protected $table = 'gudang';
    public $timestamps = false;
    use HasFactory;

    public function barang()
    {
        return $this->belongsToMany(barang_mentah::class, 'gudang_has_barang_mentah','gudang_id','barang_id')->withPivot('jumlah');
    }
    public function produk()
    {
        return $this->belongsToMany(produk::class, 'gudang_has_produk','gudang_id','produk_id')->withPivot('jumlah');
    }

}
