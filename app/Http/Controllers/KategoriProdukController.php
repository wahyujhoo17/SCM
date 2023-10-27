<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storekategori_produkRequest;
use App\Http\Requests\Updatekategori_produkRequest;
use App\Models\kategori_produk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kp = kategori_produk::all();
        // dd($dp);
        return view('produk.daftar_kategori', ['data' => $kp]);
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
     * @param  \App\Http\Requests\Storekategori_produkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new kategori_produk();
        $data->nama = $request->get('nama');
        $data->keterangan = $request->get('keterangan');
        $data->save();
        return redirect()->back()->with('alert', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kategori_produk  $kategori_produk
     * @return \Illuminate\Http\Response
     */
    public function show(kategori_produk $kategori_produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kategori_produk  $kategori_produk
     * @return \Illuminate\Http\Response
     */
    public function edit(kategori_produk $kategori_produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatekategori_produkRequest  $request
     * @param  \App\Models\kategori_produk  $kategori_produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = kategori_produk::find($id);
        $data->nama = $request->get('Unama');
        $data->keterangan = $request->get('Uketerangan');
        $data->save();
        return redirect()->back()->with('alert', 'Data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kategori_produk  $kategori_produk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $kategori = kategori_produk::find($id);
        try {
            $kategori->delete();
            return redirect()->back()->with('alert', 'Data berhasil di hapus');
        } catch (\Throwable $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('alert_gagal', 'Data gagal di hapus');
        }
    }
}
