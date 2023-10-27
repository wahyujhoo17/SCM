<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nota_pemesanan extends Model
{
    use HasFactory;

    protected $table = 'nota_pemesanan';
    public $timestamps = false;

    public function pemasok()
    {
        return $this->belongsTo(pemasok::class, 'pemasok_id');
    }
    public function pegawai()
    {
        return $this->belongsTo(pegawai::class, 'user_id');
    }

    public function barang()
    {
        return $this->belongsToMany(barang_mentah::class ,'nota_pemesanan_has_barang','nota_pemesanan_id','barang_id')->withPivot('harga_beli', 'jumlah_barang');
    }
    public function produk()
    {
        return $this->belongsToMany(produk::class ,'nota_pemesanan_has_produk','nota_pemesanan_id','produk_id')->withPivot('harga_beli', 'jumlah_barang');
    }
    public function pembelian()
    {
        return $this->hasMany(nota_pembelian::class ,'nota_pemesanan_id','id');
    }
}
