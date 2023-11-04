<?php

namespace App\Http\Controllers;

use App\Models\penjualan;
use App\Models\produk;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class laporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        dd('masok index');
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
    public function laporanHarian(){

        $penjualan = penjualan::orderBy('tanggal' , 'desc')->get();
        
        return view('laporan.laporan_harian' , compact('penjualan'));
    }

    public function laporanProduk(){
        $produk = produk::all();

        $data = [];
        for ($i=0; $i < count( $produk) ; $i++) { 
            $penjualan = $produk[$i]->nota_penjualan;
            // $data[] = $produk[$i]->nama;
            
            $total = 0;
            for ($j=0; $j < count($penjualan) ; $j++) { 
                $detail = $penjualan[$j]->pivot->jumlah;
                $total += $detail;
            }

            $data[]= ['nama'=> $produk[$i]->nama , 'jumlah' => $total];
        }

        dd($data);
    }
}
