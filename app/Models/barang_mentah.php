<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_mentah extends Model
{
    protected $table = 'barang';
    public $timestamps = false;
    use HasFactory;

    public function pembelian_detail_nota_barang(){
        return $this->hasMany(pembelian_detail_nota_barang::class ,'barang_id' , 'id');
    }

    public function nota_pembelian_barang()
    {
        return $this->belongsToMany(nota_pembelian_barang::class, 'barang_has_nota_pembelian_barang','barang_id','nota_pembelian_barang_id');
    }
    
    public function pemasok()
    {
        return $this->belongsToMany(pemasok::class ,'pemasok_has_barang','barang_id','pemasok_id');
    }
    public function nota_pemesanan()
    {
        return $this->belongsToMany(nota_pemesanan::class, 'nota_pemesanan_has_barang','barang_id','nota_pemesanan_id');
    }
    public function nota_pembelian()
    {
        return $this->belongsToMany(nota_pembelian::class, 'nota_pembelian_has_barang','barang_id','nota_pembelian_id');
    }

    public function gudang()
    {
        return $this->belongsToMany(gudang::class, 'gudang_has_barang_mentah','barang_id','gudang_id')->withPivot('jumlah');
    }
    public function perputaran_barang()
    {
        return $this->belongsToMany(perputaran_barang::class, 'barang_has_perputaran_barang','barang_id','perputaran_barang_id')->withPivot('jumlah');
    }

    public function satuan()
    {
        return $this->belongsTo(satuan::class, 'satuan_id');
    }
}

