<?php

namespace App\Http\Controllers;

use App\Models\mutasi_stok;
use Illuminate\Http\Request;

class MutasiStokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mutasi = mutasi_stok::all();
        return view('persediaan.stok.mutasi_stok' , ['data'=> $mutasi]);
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
     * @param  \App\Http\Requests\Storemutasi_stokRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mutasi_stok  $mutasi_stok
     * @return \Illuminate\Http\Response
     */
    public function show(mutasi_stok $mutasi_stok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mutasi_stok  $mutasi_stok
     * @return \Illuminate\Http\Response
     */
    public function edit(mutasi_stok $mutasi_stok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatemutasi_stokRequest  $request
     * @param  \App\Models\mutasi_stok  $mutasi_stok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mutasi_stok $mutasi_stok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mutasi_stok  $mutasi_stok
     * @return \Illuminate\Http\Response
     */
    public function destroy(mutasi_stok $mutasi_stok)
    {
        //
    }
}
