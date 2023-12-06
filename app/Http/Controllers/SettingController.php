<?php

namespace App\Http\Controllers;

use App\Models\eoq_ss;
use App\Models\jenis_pembayaran;
use App\Models\pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = pegawai::where('id', Auth::user()->id)->first();
        $eoq = eoq_ss::where('id' , 1)->first();
        $jp = jenis_pembayaran::all();

        return view('setting.setting', compact('user' , 'eoq' , 'jp'));
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
        $user = pegawai::where('id', Auth::user()->id)->first();

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_tlp = $request->no_tlp;
        $user->alamat = $request->alamat;
        $user->save();

        return redirect()->back()->with('alert', 'Data berhasil diubah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function ubahPassword(Request $request)
    {

        $user = pegawai::where('id', Auth::user()->id)->first();

        $plainTextPassword = $request->passwordLama;
        $hashedPasswordFromDatabase = $user->password;
        $newPassword = $request->passwordBaru;

        if (Hash::check($plainTextPassword, $hashedPasswordFromDatabase)) {
            $user->password = Hash::make($newPassword);
        } else {
            return redirect()->back()->with('error', 'Password yang anda masukkan salah');
        }
        $user->save();

        return redirect()->back()->with('alert', 'Password Berhasil diubah');
    }

    public function EOQ(Request $request){

        $eoq = eoq_ss::where('id' , 1)->first();

        $eoq->tanggal_awal = $request->startDate;   
        $eoq->tanggal_akhir = $request->endDate;

        $eoq->save();

        return redirect()->back()->with('alert', 'data Parameter EOQ berhasil diubah');
    }

    public function SS(Request $request){

        $eoq = eoq_ss::where('id' , 1)->first();

        $leadTime = $request->leadTime;
        $confidenceLevel = $request->confidenceLevel;

        $eoq->Zscore = $confidenceLevel;
        $eoq->Ltime = $leadTime;
        $eoq->save();

        return redirect()->back()->with('alert', 'data Parameter SS berhasil diubah');
    }
}
