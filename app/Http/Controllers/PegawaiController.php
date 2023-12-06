<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepegawaiRequest;
use App\Http\Requests\UpdatepegawaiRequest;
use App\Models\jabatan;
use App\Models\outlet;
use App\Models\pegawai;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pl = pegawai::all();
        $jabatan = jabatan::all();
        return view('pegawai.daftar_pegawai', ['data' => $pl, 'kt' => $jabatan]);
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
     * @param  \App\Http\Requests\StorepegawaiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id_generaor = IdGenerator::generate((['table' => 'users', 'field' => 'user_id', 'length' => 5, 'prefix' => 'EM']));
        //
        $data = new pegawai();
        $data->user_id = $id_generaor;
        $data->nama = $request->get('nama');
        $data->alamat = $request->get('alamat');
        $data->email = $request->get('email');
        $data->no_tlp = $request->get('telepon');
        $data->jabatan_id = $request->get('jabatan');
        $data->password = Hash::make('jayaabadi');
        $data->save();

        if($request->get('jabatan') == 3){
            $data->outlet()->attach($request->lokasi);
        }
        return redirect()->back()->with('alert', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $expload = explode('-' , $id);
        if($expload[1] == 'Casir'){

            $outlet =outlet::all();
            return response()->json(array(
                'msg' => $outlet
            ),200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $pegawai = pegawai::where('id', $id)->first();
        $jabatan = jabatan::all();
        $outlet = outlet::all();

        return response()->json(array(
            'msg' => view('pegawai.ubahModal' , compact('pegawai', 'jabatan', 'outlet'))->render()
        ),200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepegawaiRequest  $request
     * @param  \App\Models\pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {
        //
        $nama = $request->Unama;
        $alamat = $request->Ualamat;
        $telepon = $request->Utelepon;
        $jabatan = $request->get('Ujabatan');
        $email = $request->get('Uemail');


        $pegawai = pegawai::where('user_id' , $id)->first();
        $pegawai->nama = $nama;
        $pegawai->alamat = $alamat;
        $pegawai->no_tlp = $telepon;
        $pegawai->jabatan_id = $jabatan;
        $pegawai->email = $email;
        $pegawai->save();

        if($jabatan == 3){
            $lokasi = $request->Ulokasi;

            $pegawai->outlet()->sync($lokasi);
        }



        return redirect()->back()->with('alert', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy(pegawai $pegawai)
    {
        //
    }
}
