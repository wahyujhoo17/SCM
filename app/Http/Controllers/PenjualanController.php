<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepenjualanRequest;
use App\Http\Requests\UpdatepenjualanRequest;
use App\Models\jenis_pembayaran;
use App\Models\outlet;
use App\Models\pelanggan;
use App\Models\pembayaran;
use App\Models\penjualan;
use App\Models\produk;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $produk = produk::all();
        $pelanggan = pelanggan::all();
        $outlet = outlet::all();
        $pembayaran =  jenis_pembayaran::all();
        return view('penjualan.penjualan', ['produk' => $produk, 'pelanggan' => $pelanggan , 'outlet'=>$outlet , 'pembayaran'=>$pembayaran]);
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
     * @param  \App\Http\Requests\StorepenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $val = $request->get('value');

        if ($val == 'barcode') {

            $produk = produk::where('barcode', $id)->first();
            return response()->json(array(
                'produk' => $produk
            ));
        } else {

            $produk = produk::where('id', $id)->first();
            return response()->json(array(
                'produk' => $produk
            ));
        }
    }
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'total_harga' => 'required|numeric',
            'nominal' => 'required|numeric',
            'kembalian' => 'required|numeric'
         ]);

         $id_generator = IdGenerator::generate((['table' => 'nota_penjualan', 'field' => 'nomor_nota', 'length' => 12, 'prefix' => 'OP/'.date('d')]));

         //ITEM
         $iId = $request->get('id');
         $iJumlah = $request->get('jumlah');

         //Nota
         $outlet_id = $request->get('outlet');
         
         $pembeli_id =explode("|" ,$request->get('nama-pembeli'));
         $metode_bayar_id = $request->get('metode_bayar');
         $total_harga = str_replace('.','',$request->get('total_harga')) ;
         $total_bayar = $request->get('nominal');
         $diskon = $request->get('diskon');

         //ADD TO DATABASE

         $np = new penjualan();
         $np->pelanggan_id = $pembeli_id[0];
         $np->total_harga = $total_harga;
         $np->outlet_id = $outlet_id;
         $np->jenis_pembayaran_id = $metode_bayar_id;
         $np->nomor_nota = $id_generator;
         $np->total_bayar = $total_bayar;
         $np->diskon = $diskon;
         $np->users_id = Auth::user()->id;
         $np->save();

         for ($i=0; $i < count($iId) ; $i++) { 
            $inp_Nomor = $iId[$i];
            $produk = produk::where('produk_id' , $inp_Nomor)->first();

            //
            $inp_id = $produk->id;
            $inp_jumlah = $iJumlah[$i];

            $np->produk()->attach($inp_id,[
                'jumlah' => $inp_jumlah
            ]);
         }

         return redirect()->back()->with('alert', 'Pembelian Berhasil!');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepenjualanRequest  $request
     * @param  \App\Models\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepenjualanRequest $request, penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(penjualan $penjualan)
    {
        //
    }
    public function daftarPenjualan(){
        
        $penjualan = penjualan::orderBy('tanggal', 'desc')->get();
        // dd($penjualan);
        return view('penjualan.daftar-penjualan', ['penjualan' =>$penjualan]);
    }

    public function getDetail(Request $request){
        $penjualan = penjualan::find($request->get('id'));
        return response()->json(array(
            'msg' => view('penjualan.detail-penjualan', compact('penjualan'))->render()
        ), 200);
    }
}
