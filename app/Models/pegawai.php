<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    protected $table = 'users';
    // public $timestamps = false;
    use HasFactory;

    public function jabatan()
    {
        return $this->belongsTo(jabatan::class, 'jabatan_id');
    }
    public function stok_opname()
    {
        return $this->hasMany(stok_opname::class, 'user_id' , 'id');
    }

    public function pengiriman()
    {
        return $this->hasMany(pengiriman::class, 'user_id' , 'id');
    }
    public function outlet(){
        return $this->belongsToMany(outlet::class, 'outlet_has_pegawai' , 'pegawai_id' , 'outlet_id');
    }
    public function permintaanStok()
    {
        return $this->hasMany(permintaanStokOutlet::class, 'users_id' , 'id');
    }
    public function produksi()
    {
        return $this->hasMany(produksi::class, 'user_id' , 'id');
    }
}
