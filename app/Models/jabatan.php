<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    protected $table = 'jabatan';
    public $timestamps = false;

    use HasFactory;

    public function pegawai(){
        return $this->hasMany(pegawai::class ,'jabatan_id' , 'id');
    }
}
