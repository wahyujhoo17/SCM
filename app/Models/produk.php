<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $table = 'produk';
    public $timestamps = false;
    use HasFactory;

    public function kategori()
    {
        return $this->belongsTo(kategori_produk::class, 'kategori_produk_id');
    }

    public function nota_pembelian_produk()
    {
        return $this->belongsToMany(nota_pembelian_produk::class, 'produk_has_nota_pembelian_produk','produk_id','nota_pembelian_produk_id');
    }
    
    public function pemasok()
    {
        return $this->belongsToMany(pemasok::class ,'pemasok_has_produk','produk_id','pemasok_id');
    }

    public function nota_pemesanan()
    {
        return $this->belongsToMany(nota_pemesanan::class, 'nota_pemesanan_has_produk','produk_id','nota_pemesanan_id');
    }
    public function nota_pembelian()
    {
        return $this->belongsToMany(nota_pembelian::class, 'nota_pembelian_has_produk','produk_id','nota_pembelian_id');
    }
    public function gudang()
    {
        return $this->belongsToMany(gudang::class, 'gudang_has_produk','produk_id','gudang_id')->withPivot('jumlah');
    }
    public function perputaran_produk()
    {
        return $this->belongsToMany(perputaran_produk::class, 'produk_has_perputaran_produk','produk_id','perputaran_produk_id')->withPivot('jumlah');
    }

    public function nota_penjualan()
    {
        return $this->belongsToMany(penjualan::class, 'detail_nota_penjualan','produk_id','nota_penjualan_id')->withPivot('jumlah');
    }
}

