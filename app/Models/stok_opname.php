<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stok_opname extends Model
{
    protected $table = 'stok_opname';
    public $timestamps = false;
    use HasFactory;


    public function pegawai()
    {
        return $this->belongsTo(pegawai::class, 'user_id');
    }

    public function gudang()
    {
        return $this->belongsTo(gudang::class, 'gudang_id');
    }

    public function produk()
    {
        return $this->belongsToMany(produk::class, 'stok_opname_has_produk', 'stok_opname_id', 'produk_id')->withPivot('jumlah_sistem', 'jumlah_perhitungan' , 'selisih' , 'keterangan' , 'keterangan2');
    }
}
