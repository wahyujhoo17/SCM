<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class outlet extends Model
{
    protected $table = 'outlet';
    public $timestamps = false;
    use HasFactory;

    public function penjualan(){
        return $this->hasMany(penjualan::class,'outlet_id' , 'id');
    }
    
}
