<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    protected $table = 'pesanan';
    public $timestamps = false;
    use HasFactory;

    public function produk()
    {
        return $this->belongsToMany(produk::class ,'detail_pesanan','pesanan_id','produk_id')->withPivot('harga_beli','jumlah');
    }

    public function pelanggan(){
        return $this->belongsTo(pelanggan::class,'pelanggan_id');
    }
}
