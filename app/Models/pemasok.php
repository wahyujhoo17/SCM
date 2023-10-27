<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemasok extends Model
{
    protected $table = 'pemasok';
    public $timestamps = false;
    use HasFactory;

    public function pembelian_barang(){
        return $this->hasMany(nota_pembelian_barang::class ,'pemasok_id','id');
    }
    public function pembelian_produk(){
        return $this->hasMany(nota_pembelian_produk::class ,'user_id' , 'id');
    }
    public function barang()
    {
        return $this->belongsToMany(barang_mentah::class ,'pemasok_has_barang','pemasok_id','barang_id');
    }
    public function produk()
    {
        return $this->belongsToMany(produk::class ,'pemasok_has_produk','pemasok_id','produk_id');
    }
}
