<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoregudangRequest;
use App\Http\Requests\UpdategudangRequest;
use App\Models\gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $gudang = gudang::all();
        return view('persediaan.gudang.daftar_gudang', ['data'=> $gudang]);

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
     * @param  \App\Http\Requests\StoregudangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function show(gudang $gudang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $id = $request->get('id');
        $gudang = gudang::find($id);

        return response()->json(array(
            'msg' => view('persediaan.gudang.ubah_gudang_modal' , compact('gudang'))->render()
        ),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdategudangRequest  $request
     * @param  \App\Models\gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $gudang = gudang::find($id);
        $gudang->nama =$request->get('nama-gudang');
        $gudang->alamat = $request->get('alamat');
        $gudang->save();

        return redirect()->back()->with('alert', 'Data berhasil diubah!');
        // dd($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function destroy(gudang $gudang)
    {
        //
    }
    
}
