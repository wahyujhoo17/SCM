<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class outlet extends Model
{
    protected $table = 'outlet';
    public $timestamps = false;
    use HasFactory;

    public function penjualan(){
        return $this->hasMany(penjualan::class,'outlet_id' , 'id');
    }
    public function pegawai(){
        return $this->belongsToMany(pegawai::class, 'outlet_has_pegawai' , 'outlet_id' , 'pegawai_id');
    }
    public function produk(){
        return $this->belongsToMany(produk::class, 'stok_outlet' , 'outlet_id' , 'produk_id')->withPivot('jumlah');
    }
    public function permintaanStok(){
        return $this->hasMany(permintaanStokOutlet::class,'outlet_id' , 'id');
    }
}
