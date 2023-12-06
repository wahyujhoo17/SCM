<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengiriman extends Model
{
    protected $table = 'pengiriman';
    public $timestamps = false;

    use HasFactory;

    public function pesanan(){
        return $this->belongsTo(pesanan::class,'pesanan_id');
    }

    public function pegawai(){
        return $this->belongsTo(pegawai::class,'user_id');
    }
}
