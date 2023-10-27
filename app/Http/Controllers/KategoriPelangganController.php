<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storekategori_pelangganRequest;
use App\Http\Requests\Updatekategori_pelangganRequest;
use App\Models\kategori_pelanggan;
use Illuminate\Http\Request;

class KategoriPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kp = kategori_pelanggan::all();
        // dd($dp);
        return view('pelanggan.kategori_pelanggan', ['data' => $kp]);
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
     * @param  \App\Http\Requests\Storekategori_pelangganRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = new kategori_pelanggan();
        $data->nama = $request->get('nama');
        $data->nominal_diskon = $request->get('diskon');
        $data->save();
        return redirect()->back()->with('alert', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kategori_pelanggan  $kategori_pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(kategori_pelanggan $kategori_pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kategori_pelanggan  $kategori_pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatekategori_pelangganRequest  $request
     * @param  \App\Models\kategori_pelanggan  $kategori_pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
        $data = kategori_pelanggan::find($id);
        $data->nama = $request->get('Unama');
        $data->nominal_diskon = $request->get('Udiskon');
        $data->save();
        return redirect()->back()->with('alert', 'Data berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kategori_pelanggan  $kategori_pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $kategori = kategori_pelanggan::find($id);
        try {
            $kategori->delete();
            return redirect()->back()->with('alert', 'Data berhasil di hapus');
        } catch (\Throwable $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('alert_gagal', 'Data gagal di hapus');
        }
    }
}
