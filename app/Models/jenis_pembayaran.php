<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenis_pembayaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pembayaran';
    public $timestamps = false;


    public function pembayaran()
    {
        return $this->hasMany(pembayaran::class ,'jenis_pembayaran_id' , 'id');
    }

    public function penjualan(){
        return $this->hasMany(penjualan::class , 'jenis_pembayaran_id' , 'id');
    }
}
