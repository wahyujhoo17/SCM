<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\pembayaran;
use App\Models\penjualan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    //Login fungtion
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $start = now()->subDay()->startOfDay();
        $end = now()->subDay()->endOfDay();
        $now = now()->endOfDay();

        //TOTAL PENJUALAN
        $penjualanKemarin = penjualan::whereBetween('tanggal', [$start, $end])
            ->sum('total_harga');
        $penjualanskrang = penjualan::whereBetween('tanggal', [$end, $now])
            ->sum('total_harga');

        // dd($penjualanKemarin);

        //PERSENTASE
        if ($penjualanKemarin != 0) {
            $persentase = (($penjualanskrang - $penjualanKemarin) / $penjualanKemarin) * 100;
        } else {
            $persentase = 100;
        }
        $dataPenjualan = [$penjualanskrang, round($persentase)];

        //KEUNTUNGAN // JUMLAH TERJUAL // JUMLAH TRANSAKSI
        $penjualan = penjualan::whereBetween('tanggal', [$end, $now])->get();
        $penjualan2 = penjualan::whereBetween('tanggal', [$start, $end])->get();
        $keuntungan = 0;
        $keuntungan2 = 0;
        $dataKeuntungan = [];
        //PRODUK PERJUAL
        $produkTerjual = 0;
        $produkTerjual2 = 0;
        $dataProdukTerjual = [];
        //JUMLAH TRANSAKSI
        $count = 0;
        $count2 = 0;
        $dataTransaksi = [];
        foreach ($penjualan as  $key) {
            $count++;
            foreach ($key->produk as $value) {
                $keuntungan += ((int)$value->harga_jual - (int)$value->harga_beli) * (int)$value->pivot->jumlah;
                $produkTerjual += (int)$value->pivot->jumlah;
            }
        }
        foreach ($penjualan2 as  $key) {
            $count2++;
            foreach ($key->produk as $value) {
                $keuntungan2 += ((int)$value->harga_jual - (int)$value->harga_beli) * (int)$value->pivot->jumlah;
                $produkTerjual2 += (int)$value->pivot->jumlah;
            }
        }
        if ($keuntungan2 != 0 && $keuntungan != 0) {
            $persentase = (($keuntungan - $keuntungan2) / $keuntungan2) * 100;
            $dataKeuntungan = [$keuntungan, round($persentase)];
        } else {
            $persentase = 100;
            $dataKeuntungan = [$keuntungan, $persentase];
        }
        //PRODUK TERJUAL
        if ($produkTerjual2 != 0) {
            $persentase = (($produkTerjual - $produkTerjual2) / $produkTerjual2) * 100;
            $dataProdukTerjual = [$produkTerjual, round($persentase)];
        } else {
            $persentase = 100;
            $dataProdukTerjual = [$produkTerjual, $persentase];
        }
        //JUMLAH TRANSAKASI
        if ($count2 != 0) {
            $persentase = ($count - $count2) / $count2 * 100;
            $dataTransaksi = [$count, round($persentase)];
        } else {
            $persentase = 100;
            $dataTransaksi = [$count, $persentase];
        }


        //PENERIMAAN
        $penerimaan = 0;
        $penerimaan2 = 0;
        $dataPenerimaan = [];
        $pembayaran = pembayaran::whereBetween('tanggal', [$end, $now])->get();
        $pembayaran2 = pembayaran::whereBetween('tanggal', [$start, $end])->get();
        foreach ($pembayaran as $p) {
            if ($p->invoice->isNotEmpty()) {
                $penerimaan += (int)$p->total_bayar;
            }
        }
        foreach ($pembayaran2 as $p) {
            if ($p->invoice->isNotEmpty()) {
                $penerimaan2 += (int)$p->total_bayar;
            }
        }
        if ($penerimaan2 != 0) {
            $persentase = (($penerimaan - $penerimaan2) / $penerimaan2) * 100;
            $dataPenerimaan = [$penerimaan, round($persentase)];
        } else {
            $persentase = 100;
            $dataPenerimaan = [$penerimaan, round($persentase)];
        }

        //GRAFIK PENJUALAN
        $penjualan = Penjualan::whereBetween('tanggal', [$end, $now])->orderByRaw("STR_TO_DATE(tanggal, '%H:%i:%s')")->get();

        $waktuPenjualan = collect();

        $penjualan->each(function ($penjualanItem) use ($waktuPenjualan) {
            $penjualanItem->produk->each(function ($produkItem) use ($penjualanItem, $waktuPenjualan) {
                $waktuPenjualan->push([
                    'jam' => \Carbon\Carbon::parse($penjualanItem->tanggal)->format('H:i:s'),
                    'total_penjualan' => $produkItem->pivot->jumlah,
                ]);
            });
        });
        $arrayPunch = $waktuPenjualan->pluck('total_penjualan', 'jam')->toArray();
        // dd($arrayPunch);
        return view('dashbord', compact('dataPenjualan', 'dataKeuntungan', 'dataPenerimaan', 'dataProdukTerjual', 'dataTransaksi' , 'waktuPenjualan' , 'arrayPunch'));
    }
}
