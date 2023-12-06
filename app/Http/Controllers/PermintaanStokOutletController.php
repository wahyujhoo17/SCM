<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepermintaanStokOutletRequest;
use App\Http\Requests\UpdatepermintaanStokOutletRequest;
use App\Models\gudang;
use App\Models\permintaanStokOutlet;
use App\Models\produk;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermintaanStokOutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $id_generator = IdGenerator::generate((['table' => 'permintaan_stok', 'field' => 'nomor', 'length' => 12, 'prefix' => 'RO-'.date('m')]));
        $gudang = gudang::all();
        $permintaanStok = permintaanStokOutlet::where('outlet_id' , Auth::user()->outlet[0]->id)->get();
        return view('outlet.permintaanStok', ['data' => $permintaanStok , 'gudang'=> $gudang , 'idG'=>$id_generator]);
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
     * @param  \App\Http\Requests\StorepermintaanStokOutletRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $id_generator = IdGenerator::generate((['table' => 'permintaan_stok', 'field' => 'nomor', 'length' => 12, 'prefix' => 'RO-'.date('m')]));
        $gudang = $request->gudang;
        $productData = $request->productData;
        $data = json_decode($productData, true);


        $MT = new permintaanStokOutlet();
        $MT->outlet_id = Auth::user()->outlet[0]->id;
        $MT->status = 'Diminta';
        $MT->nomor = $id_generator;
        $MT->users_id = Auth::user()->id;
        $MT->gudang_id = $gudang;
        $MT->save();
        

        for ($i=0; $i < count($data) ; $i++) { 
            $idProduk = produk::where('produk_id', $data[$i]['id'])->first();
            
            $MT->produk()->attach($idProduk->id, ['jumlah' => $data[$i]['quantity']]);
        }

        return redirect()->back()->with('alert', 'Data berhasil dikirimkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\permintaanStokOutlet  $permintaanStokOutlet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $ps= permintaanStokOutlet::find($id);
        

        return response()->json(array(
            'view' => view('outlet.viewPermintaan' , compact('ps'))->render()
        ),200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\permintaanStokOutlet  $permintaanStokOutlet
     * @return \Illuminate\Http\Response
     */
    public function edit(permintaanStokOutlet $permintaanStokOutlet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepermintaanStokOutletRequest  $request
     * @param  \App\Models\permintaanStokOutlet  $permintaanStokOutlet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepermintaanStokOutletRequest $request, permintaanStokOutlet $permintaanStokOutlet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\permintaanStokOutlet  $permintaanStokOutlet
     * @return \Illuminate\Http\Response
     */
    public function destroy(permintaanStokOutlet $permintaanStokOutlet)
    {
        //
    }
    public function getProduk($id){

        $gudang = gudang::find($id);

        return response()->json(array(
            'msg' => $gudang->produk
        ),200);
    }
}
