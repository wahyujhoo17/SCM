<?php

namespace App\Http\Controllers;

use App\Models\area_gudang;
use App\Models\barang_mentah;
use App\Models\gudang;
use App\Models\nota_pembelian;
use App\Models\outlet;
use App\Models\permintaanStokOutlet;
use App\Models\perputaran_barang;
use App\Models\perputaran_produk;
use App\Models\produk;
use App\Models\produksi;
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
        $permintaan = permintaanStokOutlet::where('status', 'Diminta')->get();
        $produksi = produksi::where('status_produksi' , 'Konfirmasi Gudang')->get();

        return view('persediaan.gudang.konfirmasi_gudang', ['data' => $data, 'gudang' => $gudang, 'permintaan' => $permintaan , 'produksi' =>$produksi]);
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
            $pb->keterangan = "Produk masuk dari nota Pembelian : " . $noNota;
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
                if ($gudang->produk->find($inp_id) == null) {
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
            $pb->keterangan = "Barang masuk dari nota Pembelian : " . $noNota;
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
                if ($gudang->barang->find($inp_id) == null) {
                    $gudang->barang()->attach($inp_id, ['jumlah' => $inp_quantity]);
                } else {
                    $sisa = $gudang->barang[$i]->pivot->jumlah;
                    $total = $sisa + $inp_quantity;
                    $gudang->barang()->updateExistingPivot($inp_id, ['jumlah' => $total]);
                }
            }
        }

        //Update Pembelin
        $updateNota = nota_pembelian::where('no_nota', $noNota)->first();
        if ($updateNota->status_pembelian == 'diproses') {
            $updateNota->status_pembelian = 'belum dibayar';
        } else if ($updateNota->status_pembelian == 'belum diterima') {
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
    public function viewPermintaan($id)
    {

        $permintaan = permintaanStokOutlet::find($id);

        return response()->json(array(
            'msg' => view('persediaan.gudang.konfirmasi_permintaan_modal', compact('permintaan'))->render()
        ), 200);
    }

    public function konfirmasiPermintaan(Request $request)
    {

        // dd($request);
        $permintaan = permintaanStokOutlet::where('nomor', $request->nomorPermintaan)->first();
        $gudang = gudang::find($request->gudang);

        $produk_id = $request->produk_id;
        $jumlah = $request->jumlah;

        //outlet
        $outlet = outlet::find($permintaan->outlet_id);

        //Tambahkan Ke Perputaran Produk
        $pb = new perputaran_produk();
        $pb->status = "keluar";
        $pb->keterangan = "Produk keluar dengan nomor permintaan  : " . $permintaan->nomor;
        $pb->user_id = Auth::user()->id;
        $pb->gudang_id = $gudang->id;
        $pb->save();

        for ($i = 0; $i < count($produk_id); $i++) {

            //Tambah DI Perputaran Produk
            $inp_id = $produk_id[$i];
            $inp_quantity = $jumlah[$i];

            //Tambahkan Ke Detail
            $produk = produk::where('produk_id', $inp_id)->first();
            $pb->produk()->attach($produk->id, ['jumlah' => $inp_quantity]);

            //Tambah Stok Pada Outlet
            if ($outlet->produk->find($produk->id) == null) {
                $outlet->produk()->attach($produk->id, ['jumlah' => $inp_quantity]);
            } else {
                $sisa = $outlet->produk->find($produk->id)->pivot->jumlah;
                $total = $sisa + $inp_quantity;
                $outlet->produk()->updateExistingPivot($produk->id, ['jumlah' => $total]);
            }

            //Kurangi isi Stok Gudanga
            $sisa = $gudang->produk->find($produk->id)->pivot->jumlah;
            $total = $sisa - $inp_quantity;
            $gudang->produk()->updateExistingPivot($produk->id, ['jumlah' => $total]);
        }
        //Ubah Status Permintaan
        $permintaan->status = "Selesai";
        $permintaan->save();

        return redirect()->back()->with('alert', 'Berhasil Di konfirmasi');
    }

    public function getKonfirmasiProduksi($id){

        $produksi = produksi::find($id);
        $gudang = gudang::all();
        return response()->json(array(
            'msg' => view('persediaan.gudang.konfirmasi_produksi_modal', compact('produksi', 'gudang'))->render()
        ), 200);
    }

    public function konfirmasiProduksi(Request $request){
        $produksi = produksi::where('nomor' , $request->no_nota)->first();
        $gudangid = $request->gudang;
        $jumlah = $request->quantity;

        $gudang = gudang::find($gudangid);
        $stok = $gudang->produk()->find($produksi->produk_id);

        if ($stok == null) {
            $gudang->produk()->attach($produksi->produk_id, ['jumlah' => $jumlah]);
        } else {
            $sisa = $stok->pivot->jumlah;
            $total = (int)$sisa + (int)$jumlah;

            $gudang->produk()->updateExistingPivot($produksi->produk_id, ['jumlah' => strval($total)]);
        }

        $pb = new perputaran_produk();
        $pb->status = "masuk";
        $pb->keterangan = "Produk masuk dari nota Produksi : " . $request->no_nota;
        $pb->user_id = Auth::user()->id;
        $pb->gudang_id = $gudangid;
        $pb->save();

        $pb->produk()->attach($produksi->produk_id, ['jumlah' => $jumlah]);


        $produksi->status_produksi = 'Selesai';
        $produksi->save();

        return redirect()->back()->with('alert', 'Berhasil Di konfirmasi');
    }
}
