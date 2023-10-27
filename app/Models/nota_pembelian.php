<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nota_pembelian extends Model
{

    use HasFactory;

    protected $table = 'nota_pembelian';
    public $timestamps = false;

    public function pemasok()
    {
        return $this->belongsTo(pemasok::class, 'pemasok_id');
    }
    public function pegawai()
    {
        return $this->belongsTo(pegawai::class, 'user_id');
    }
    public function produk()
    {
        return $this->belongsToMany(produk::class ,'nota_pembelian_has_produk','nota_pembelian_id','produk_id')->withPivot('harga_beli', 'jumlah');
    }
    public function barang()
    {
        return $this->belongsToMany(barang_mentah::class ,'nota_pembelian_has_barang','nota_pembelian_id','barang_id')->withPivot('harga_beli', 'jumlah');
    }

    public function pemesanan()
    {
        return $this->belongsTo(nota_pemesanan::class ,'nota_pemesanan_id');
    }
    
    public function pembayarans()
    {
        return $this->belongsToMany(pembayaran::class ,'nota_pembelian_has_pembayaran','nota_pembelian_id','pembayaran_id');
    }
}
