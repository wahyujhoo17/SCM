<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori_produk extends Model
{
    protected $table = 'kategori_produk';
    public $timestamps = false;
    use HasFactory;

    public function produk(){
        return $this->hasMany(produk::class ,'kategori_produk_id' , 'id');
    }
}
