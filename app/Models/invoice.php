<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{

    protected $table = 'invoice';
    public $timestamps = false;

    use HasFactory;

    public function produk()
    {
        return $this->belongsToMany(produk::class ,'invoice_has_produk','invoice_id','produk_id')->withPivot('harga','jumlah','total');
    }

    public function pelanggan(){
        return $this->belongsTo(pelanggan::class,'pelanggan_id');
    }
    public function pembayaran(){
        return $this->belongsToMany(pembayaran::class ,'invoice_has_pembayaran','invoice_id','pembayaran_id')->withPivot('harga','jumlah','total');
    }
}
