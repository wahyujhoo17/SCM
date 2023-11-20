<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepemasokRequest;
use App\Http\Requests\UpdatepemasokRequest;
use App\Models\barang_mentah;
use App\Models\pemasok;
use App\Models\produk;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pm = pemasok::all();
        return view('persediaan.pemasok', ['data' => $pm]);
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
     * @param  \App\Http\Requests\StorepemasokRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id_generaor = IdGenerator::generate((['table' => 'pemasok', 'field' => 'pemasok_id', 'length' => 5, 'prefix' => 'SP']));
        // dd($id);
        $data = new pemasok();
        $data->pemasok_id = $id_generaor;
        $data->nama = $request->get('nama');
        $data->alamat = $request->get('alamat');
        $data->no_tlp = $request->get('telepon');
        $data->email = $request->get('email');
        $data->save();
        return redirect()->back()->with('alert', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function show(pemasok $pemasok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $pemasok_id = $request->get('id');
        $pemasok = pemasok::find($pemasok_id);
        $barang = barang_mentah::all();
        $produk =  produk::all();

        return response()->json(array(
            'msg' => view('persediaan.ubah_pemasok', compact('pemasok', 'barang', 'produk'))->render()
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepemasokRequest  $request
     * @param  \App\Models\pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);

        $data = pemasok::where('pemasok_id', $id)->first();
        $data->nama = $request->get('Unama');
        $data->alamat = $request->get('Ualamat');
        $data->no_tlp = $request->get('Utelepon');
        $data->save();

        return redirect()->back()->with('alert', 'Data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = pemasok::find($id);
        try {
            $kategori->delete();
            return redirect()->back()->with('alert', 'Data berhasil di hapus');
        } catch (\Throwable $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('alert_gagal', 'Data gagal di hapus');
        }
    }
    public function addItem(Request $request)
    {

        $nama = $request->get('nama');
        $id = $request->get('id');
        $idItem = $request->get('idItem');
        $jenis = $request->get('jenis');
        $pemasok = pemasok::where('id', $id)->first();


        if ($jenis =='barang') {
            try {
                $barang = barang_mentah::where('nomor' , $idItem)->first();
                $pemasok->barang()->attach($barang->id);
                return response()->json(array(
                    'msg' => 'masuk'
                ), 200);
            } catch (\Throwable $e) {
                return response()->json(array(
                    'msg' => 'gagal'
                ), 200);
            }
        } else {
            try {
                $produk = produk::where('produk_id',$idItem)->first();
                $pemasok->produk()->attach($produk->id);
                return response()->json(array(
                    'msg' => 'masuk'
                ), 200);
            } catch (\Throwable $e) {
                return response()->json(array(
                    'msg' => 'gagal'
                ), 200);
            }
        }
    }

    public function hapusItem(Request $request){

        $pemasokId = $request->get('pemasok');
        $idItem = $request->get('item');
        $jenis = $request->get('jenis');

        $pemasok = pemasok::find($pemasokId);

        if($jenis == 'barang'){
            $barang = barang_mentah::where('nomor' , $idItem)->first();
            $pemasok->barang()->detach($barang->id);
        }
        else{
            $produk = produk::where('produk_id' , $idItem)->first();
            $pemasok->produk()->detach($produk->id);
        }

        return response()->json(array(
            'msg' => 'masuk'
        ), 200);
    }
}
