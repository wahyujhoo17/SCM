<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mutasi_stok extends Model
{

    protected $table = 'mutasi_stok';
    public $timestamps = false;
    use HasFactory;

    public function produk(){
        return $this->belongsTo(produk::class, 'produk_id');
    }
}
