<?php

namespace App\Http\Controllers;

use App\Models\kategori_produk;
use App\Models\penjualan;
use App\Models\produk;
use Illuminate\Http\Request;
use Nette\Utils\Json;
use Illuminate\Support\Facades\DB;



class laporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = penjualan::all();
        //
        $ringkasanPenjualan = penjualan::groupByRaw('MONTH(tanggal) , YEAR(tanggal)')
            ->selectRaw('MONTH(tanggal) as Bulan,YEAR(tanggal) as tahun, SUM(total_harga) AS total_penjualan')
            ->get();
        

        foreach ($ringkasanPenjualan as $revenue) {

            $nomor_bulan = $revenue->Bulan;
            $nama_bulan = date("F", strtotime("2023-$nomor_bulan-01"));
            $revenue->Bulan= $nama_bulan;
        }
        
        return view('laporan.ringkasan_laporan', ['data' => $ringkasanPenjualan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function laporanHarian()
    {

        $penjualan = penjualan::orderBy('tanggal', 'desc')->get();

        return view('laporan.laporan_harian', compact('penjualan'));
    }

    public function laporanProduk()
    {
        $produk = produk::all();

        return view('laporan.laporan-produk', compact('produk'));
    }
    public function laporanKategori(){

        $kategori = kategori_produk::all();
        return view('laporan.laporan-kategori', compact('kategori'));
    }
}
