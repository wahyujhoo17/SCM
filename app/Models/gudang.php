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

    public function stok_opname()
    {
        return $this->hasMany(stok_opname::class, 'gudang_id','id');
    }
    public function permintaan_stok()
    {
        return $this->hasMany(permintaanStokOutlet::class, 'gudang_id','id');
    }

}
