<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori_pelanggan extends Model
{
    protected $table = 'kategori_pelanggan';
    public $timestamps = false;
    use HasFactory;
    
    public function pelanggan(){
        return $this->hasMany(pelanggan::class ,'kategori_pelanggan_id' , 'id');
    }
}
