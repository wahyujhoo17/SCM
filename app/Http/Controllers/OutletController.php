<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreoutletRequest;
use App\Http\Requests\UpdateoutletRequest;
use App\Models\outlet;
use App\Models\penjualan;
use App\Models\permintaanStokOutlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $outlet = outlet::all();
        return view('outlet.daftar-outlet', ['data'=> $outlet]);
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
     * @param  \App\Http\Requests\StoreoutletRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $nama = $request->nama;
        $alamat = $request->alamat;

        $outlet = new outlet();
        $outlet->nama = $nama;
        $outlet->alamat = $alamat;
        $outlet->save();

        return redirect()->back() ->with('alert', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function show(outlet $outlet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $outlet = outlet::find($id);
        return response()->json(array(
            'msg' => view('outlet.ubahModal' , compact('outlet'))->render()
        ),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateoutletRequest  $request
     * @param  \App\Models\outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $outlet)
    {
        //
        $out = outlet::find($outlet);
        $out->nama = $request->nama;
        $out->alamat = $request->alamat;

        $out->save();
        return redirect()->back() ->with('alert', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function destroy(outlet $outlet)
    {
        //
    }

    public function mutasi(){

        $outlet = outlet::find(Auth::user()->outlet[0]->id);
        $permintaan = permintaanStokOutlet::where('outlet_id' , $outlet->id)->get();
        $penjualan = penjualan::where('outlet_id' , $outlet->id)->get();

        return view('outlet.mutasi-outlet', ['outlet'=> $outlet , 'permintaan' => $permintaan , 'penjualan' => $penjualan]);
    }
}
