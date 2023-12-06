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

    public function stok_opname(){

        return $this->belongsToMany(stok_opname::class, 'stok_opname_has_produk', 'produk_id', 'stok_opname_id')->withPivot('jumlah_sistem', 'jumlah_perhitungan' , 'selisih' , 'keterangan' , 'keterangan2');
    }
    public function mutasi_stok(){

        return $this->hasMany(mutasi_stok::class, 'produk_id' , 'id');
    }
    public function pesanan(){

        return $this->belongsToMany(pesanan::class, 'detail_pesanan', 'produk_id', 'pesanan_id')->withPivot('jumlah','harga_beli');
    }

    public function invoice(){

        return $this->belongsToMany(invoice::class, 'invoice_has_produk', 'produk_id', 'invoice_id')->withPivot('jumlah','harga', 'total');
    }

    public function outlet(){

        return $this->belongsToMany(outlet::class, 'stok_outlet', 'produk_id', 'outlet_id')->withPivot('jumlah');
    }
    public function permintaan_stok()
    {
        return $this->belongsToMany(permintaanStokOutlet::class ,'detail_permintaan','produk_id','permintaan_stok_id')->withPivot('jumlah');
    }
    public function barang()
    {
        return $this->belongsToMany(barang_mentah::class ,'resep_produk','produk_id','barang_id')->withPivot('jumlah', 'satuan');
    }
    public function produksi()
    {
        return $this->hasMany(produk::class , 'produk_id' , 'id');
    }
}

