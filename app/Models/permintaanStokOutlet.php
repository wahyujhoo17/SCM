<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permintaanStokOutlet extends Model
{
    protected $table = 'permintaan_stok';
    public $timestamps = false;

    use HasFactory;

    public function produk()
    {
        return $this->belongsToMany(produk::class, 'detail_permintaan', 'permintaan_stok_id', 'produk_id')->withPivot('jumlah');
    }
    public function outlet()
    {
        return $this->belongsTo(outlet::class, 'outlet_id');
    }
    public function pegawai()
    {
        return $this->belongsTo(pegawai::class, 'users_id');
    }
    public function gudang()
    {
        return $this->belongsTo(gudang::class, 'gudang_id');
    }
}
