<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreprodukRequest;
use App\Http\Requests\UpdateprodukRequest;
use App\Models\kategori_produk;
use App\Models\produk;
use Facade\FlareClient\Http\Response;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dp = produk::all();
        $kt = kategori_produk::all();
        // dd($dp);
        return view('produk.daftar_produk', ['data'=> $dp , 'kt'=>$kt]);
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
     * @param  \App\Http\Requests\StoreprodukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_generaor = IdGenerator::generate((['table'=>'produk' ,'field'=>'produk_id' , 'length'=> 5 , 'prefix' =>'PR']));
        //
        $data = new produk();
        $data->produk_id = $id_generaor;
        $data->nama = $request->get('nama');
        $data->barcode = $request->get('barcode');
        $data->harga_jual = $request->get('harga');
        $data->kategori_produk_id = $request->get('kategori');
        $data->save();
        return redirect()->back() ->with('alert', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $id = $request->get('id');
        $pr = produk::find($id);
        $kt = kategori_produk::all()->sortBy('nama');

        // dd($id);

        return response()->json(array(
            'msg' => view('produk.ubahModal' , compact('pr' , 'kt'))->render()
        ),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateprodukRequest  $request
     * @param  \App\Models\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
        $data = produk::where('produk_id', $id)->first();
        $data->nama = $request->get('Unama');
        $data->barcode = $request->get('Ubarcode');
        $data->harga_jual = $request->get('Uharga');
        $data->kategori_produk_id = $request->get('Ukategori');
        $data->save();
        return redirect()->back()->with('alert', 'Data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $kategori = produk::find($id);
        try {
            $kategori->delete();
            return redirect()->back()->with('alert', 'Data berhasil di hapus');
        } catch (\Throwable $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('alert_gagal', 'Data gagal di hapus');
        }
    }
    public function get_Update(Request $request){

        $id = ($request -> get('id'));
        $pr = produk::find($id);
        $kt = kategori_produk::all()->sortBy('nama');

        return response()->json(array(
            'msg' => view('produk.ubahModal' , compact('pr' , 'kt'))->render()
        ),200);

    }
}
