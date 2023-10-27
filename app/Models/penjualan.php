<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{

    protected $table = 'nota_penjualan';
    public $timestamps = false;
    use HasFactory;

    public function produk()
    {
        return $this->belongsToMany(produk::class ,'detail_nota_penjualan','nota_penjualan_id','produk_id')->withPivot('jumlah');
    }
}
