<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produksi extends Model
{
    protected $table = 'produksi';
    public $timestamps = false;
    use HasFactory;

    public function pegawai()
    {
        return $this->belongsTo(pegawai::class, 'user_id');
    }
    public function produk()
    {
        return $this->belongsTo(produk::class, 'produk_id');
    }
    public function barang()
    {
        return $this->belongsToMany(barang_mentah::class, 'barang_diambil','produksi_id','barang_id')->withPivot('jumlah', 'gudang_id');
    }
}
