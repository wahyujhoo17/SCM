<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    public $timestamps = false;

    public function nota_pembelian()
    {
        return $this->belongsToMany(nota_pembelian::class, 'nota_pembelian_has_pembayaran', 'pembayaran_id', 'nota_pembelian_id');
    }

    public function jenis_pembayaran()
    {
        return $this->belongTo(jenis_pembayaran::class, 'jenis_pembayaran_id');
    }

    public function invoice()
    {
        return $this->belongsToMany(invoice::class, 'invoice_has_pembayaran', 'pembayaran_id', 'invoice_id');
    }
}
