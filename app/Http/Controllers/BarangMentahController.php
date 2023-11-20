<?php

namespace App\Http\Controllers;

use App\Models\barang_mentah;
use App\Models\pemasok;
use App\Models\satuan;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class BarangMentahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $barang = barang_mentah::all();
        $satuan = satuan::all();
        $pemasok = pemasok::all();

        return view('persediaan.stok.daftar_barang_mentah', ['barang'=> $barang , 'satuan' => $satuan , 'pemasok' => $pemasok]);
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
        $id_generaor = IdGenerator::generate((['table'=>'barang' ,'field'=>'nomor' , 'length'=> 6 , 'prefix' =>'BM']));
        //
        $nama = $request->get('nama');
        $harga = $request->get('harga');
        $satuanId = $request->get('satuan');

        $barang = new barang_mentah();
        $barang->nama = $nama;
        $barang->harga_beli = $harga;
        $barang->satuan_id = $satuanId;
        $barang->nomor = $id_generaor;
        $barang->save();

        return redirect()->back() ->with('alert', 'Data berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\barang_mentah  $barang_mentah
     * @return \Illuminate\Http\Response
     */
    public function show(barang_mentah $barang_mentah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\barang_mentah  $barang_mentah
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $barang = barang_mentah::find($id);
        $satuan = satuan::all();

        return response()->json(array(
            'msg' => view('persediaan.stok.ubah_barang_modal' , compact('barang', 'satuan'))->render()
        ),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\barang_mentah  $barang_mentah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {
        $nama = $request->get('namaUbah');
        $harga = $request->get('hargaUbah');
        $satuan = $request->get('satuanUbah');
        //
        $update = barang_mentah::find($id);
        $update->nama = $nama;
        $update->harga_beli = $harga;
        $update->satuan_id = $satuan;
        $update->save();
        return redirect()->back()->with('alert', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\barang_mentah  $barang_mentah
     * @return \Illuminate\Http\Response
     */
    public function destroy(barang_mentah $barang_mentah)
    {
        //
    }
}
