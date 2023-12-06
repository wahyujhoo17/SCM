<?php

namespace App\Http\Controllers;

use App\Models\jenis_pembayaran;
use Illuminate\Http\Request;

class jenisPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $jenisP = new jenis_pembayaran();
        $jenisP->nama = $request->nama;
        $jenisP->save();
        
        return redirect()->back()->with('alert', 'Data Jenis Pembayaran berhasil ditambahakan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\jenis_pembayaran  $jenis_pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(jenis_pembayaran $jenis_pembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\jenis_pembayaran  $jenis_pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(jenis_pembayaran $jenis_pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\jenis_pembayaran  $jenis_pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $jenis_pembayaran)
    {
        //
        $jp = jenis_pembayaran::find($jenis_pembayaran);
        $jp->nama = $request->nama;
        $jp->save();

        return redirect()->back()->with('alert', 'Data Jenis Pembayaran berhasil diubah!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\jenis_pembayaran  $jenis_pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy( $jenis_pembayaran)
    {
        //
        $jp = jenis_pembayaran::find($jenis_pembayaran);
        $jp->destroy();

        return redirect()->back()->with('alert', 'Data Jenis Pembayaran berhasil dihapus!');
    }
}
