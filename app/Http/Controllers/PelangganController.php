<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepelangganRequest;
use App\Http\Requests\UpdatepelangganRequest;
use App\Models\kategori_pelanggan;
use App\Models\pelanggan;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pl = pelanggan::all();
        $kategori = kategori_pelanggan::all();
        return view('pelanggan.daftar_pelanggan', ['data' => $pl, 'kt' => $kategori]);
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
     * @param  \App\Http\Requests\StorepelangganRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id_generaor = IdGenerator::generate((['table' => 'pelanggan', 'field' => 'pelanggan_id', 'length' => 5, 'prefix' => 'CS']));
        //
        $data = new pelanggan();
        $data->pelanggan_id = $id_generaor;
        $data->nama = $request->get('nama');
        $data->alamat = $request->get('alamat');
        $data->no_tlp = $request->get('telepon');
        $data->kategori_pelanggan_id = $request->get('kategori');
        $data->save();
        return redirect()->back()->with('alert', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $id = $request->get('id');
        $pr = pelanggan::find($id);
        $kt = kategori_pelanggan::all()->sortBy('nama');

        return response()->json(array(
            'msg' => view('pelanggan.modal_ubah_pelanggan' , compact('pr' , 'kt'))->render()
        ),200);

        // return response()->json(array(
        //     'msg' => 'ok'
        // ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepelangganRequest  $request
     * @param  \App\Models\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $data = pelanggan::where('pelanggan_id', $id)->first();
        $data->nama = $request->get('Unama');
        $data->alamat = $request->get('Ualamat');
        $data->no_tlp = $request->get('Utelepon');
        $data->kategori_pelanggan_id = $request->get('Ukategori');
        $data->save();
        return redirect()->back()->with('alert', 'Data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $kategori = pelanggan::find($id);
        try {
            $kategori->delete();
            return redirect()->back()->with('alert', 'Data berhasil di hapus');
        } catch (\Throwable $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('alert_gagal', 'Data gagal di hapus');
        }
    }
}
