<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelanggan extends Model
{
    protected $table = 'pelanggan';
    use HasFactory;

    public function kategori_pelanggan()
    {
        return $this->belongsTo(kategori_pelanggan::class, 'kategori_pelanggan_id');
    }

    public function penjualan(){
        return $this->hasMany(penjualan::class, 'pelanggan_id' , 'id');
    }
    public function pesanan(){
        
        return $this->hasMany(pesanan::class, 'pelanggan_id' , 'id');
    }
        public function invoice(){
        
        return $this->hasMany(invoice::class, 'pelanggan_id' , 'id');
    }
}
