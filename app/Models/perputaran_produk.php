<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perputaran_produk extends Model
{
    protected $table = 'perputaran_produk';
    public $timestamps = false;
    use HasFactory;

    public function produk()
    {
        return $this->belongsToMany(produk::class ,'produk_has_perputaran_produk','perputaran_produk_id','produk_id')->withPivot('jumlah');
    }
}
