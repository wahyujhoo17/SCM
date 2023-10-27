<?php

namespace App\Http\Controllers;

use App\Models\area_gudang;
use App\Models\barang_mentah;
use App\Models\gudang;
use App\Models\nota_pembelian;
use App\Models\perputaran_barang;
use App\Models\perputaran_produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class konfirmasiGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = nota_pembelian::where('status_pembelian', 'diproses')->orWhere('status_pembelian', 'belum diterima')->get();
        $gudang = gudang::all();
        // dd($data);

        return view('persediaan.gudang.konfirmasi_gudang', ['data' => $data, 'gudang' => $gudang]);
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
        $noNota = $request->get('no_nota');
        $getNo = explode("-", $noNota);
        $idGudang = $request->get('gudang');

        //add Item
        $itemID = $request->get('item');
        $quantity = $request->get('quantity');
        //

        if ($getNo[0] == 'PP') {
            $pb = new perputaran_produk();
            $pb->status = "masuk";
            $pb->keterangan = $noNota;
            $pb->user_id = Auth::user()->id;
            $pb->gudang_id = $idGudang;
            $pb->save();

            $gudang = gudang::find($idGudang);

            for ($i = 0; $i < count($itemID); $i++) {

                //Tambah DI Perputaran Produk
                $inp_id = $itemID[$i];
                $inp_quantity = $quantity[$i];
                $pb->produk()->attach($inp_id, ['jumlah' => $inp_quantity]);

                //Tambah Stok Produk
                if ($gudang->produk->find($inp_id) == null ) {
                    $gudang->produk()->attach($inp_id, ['jumlah' => $inp_quantity]);

                } else {
                    $sisa = $gudang->produk[$i]->pivot->jumlah;
                    $total = $sisa + $inp_quantity;
                    $gudang->produk()->updateExistingPivot($inp_id, ['jumlah' => $total]);
                }
            }

        } else {
            $pb = new perputaran_barang();
            $pb->status = "masuk";
            $pb->keterangan = $noNota;
            $pb->user_id = Auth::user()->id;
            $pb->gudang_id = $idGudang;
            $pb->save();

            $gudang = gudang::find($idGudang);

            for ($i = 0; $i < count($itemID); $i++) {

                //Tambah Di Perputaran Barang
                $inp_id = $itemID[$i];
                $inp_quantity = $quantity[$i];
                $pb->barang()->attach($inp_id, ['jumlah' => $inp_quantity]);

                //Tambah Stok Barang
                if ($gudang->barang->find($inp_id) == null ) {
                    $gudang->barang()->attach($inp_id, ['jumlah' => $inp_quantity]);

                } else {
                    $sisa = $gudang->barang[$i]->pivot->jumlah;
                    $total = $sisa + $inp_quantity;
                    $gudang->barang()->updateExistingPivot($inp_id, ['jumlah' => $total]);
                    
                }
            }
        }

        //Update Pembelin
        $updateNota = nota_pembelian::where('no_nota' , $noNota)->first();
        if($updateNota->status_pembelian == 'diproses'){
            $updateNota->status_pembelian = 'belum dibayar';
        }
        else if ($updateNota->status_pembelian == 'belum diterima'){
            $updateNota->status_pembelian = 'selesai';
        }
        $updateNota->save();

        return redirect()->back()->with('alert', 'Berhasil Di konfirmasi');
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
        $detaildata = nota_pembelian::find($id);
        $gudang = gudang::all();

        return response()->json(array(
            'msg' => view('persediaan.gudang.konfirmasi_modal', compact('detaildata', 'gudang'))->render()
        ), 200);
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
}
