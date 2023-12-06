<?php

namespace App\Http\Controllers;

use App\Models\jenis_pembayaran;
use App\Models\nota_pembelian;
use App\Models\nota_pemesanan;
use App\Models\pemasok;
use App\Models\pembayaran;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Nota_pembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nota_pembelian = nota_pembelian::all();
        $pemesanan = nota_pemesanan::where('status_pemesanan', 'diproses')->get();
        // dd($pemesanan);

        return view('persediaan.nota_pembelian', ['nota' => $nota_pembelian, 'pm' => $pemesanan]);
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
        $pemesanan = $request->get('pemesanan');
        $kodePemesanan = explode('-', $pemesanan);

        $getNotaPemesanan = nota_pemesanan::where('no_nota', $pemesanan)->first();


        $idPemesanan = $getNotaPemesanan->id;
        $pemasok_id = $getNotaPemesanan->pemasok_id;

        //add Item
        $itemID = $request->get('item');
        $quantity = $request->get('quantity');
        $harga = $request->get('price');
        $total = $request->get('total');
        $totalPajakTax = str_replace('.', '', $request->get('totalAftertax'));
        $subTotal = 0;
        //Add On Database

        $nota_pembelian = new nota_pembelian();
        $nota_pembelian->pemasok_id = $pemasok_id;
        $nota_pembelian->user_id = Auth::user()->id;
        $nota_pembelian->total_harga = 0;
        $nota_pembelian->status_pembelian = 'diproses';

        $nota_pembelian->biaya_pengiriman = $request->get('pengiriman');
        $nota_pembelian->pajak = $request->get('taxRate');
        $nota_pembelian->total = $totalPajakTax;

        if ($kodePemesanan[0] == "NB") {

            $id_generator = IdGenerator::generate((['table' => 'nota_pembelian', 'field' => 'no_nota', 'length' => 12, 'prefix' => 'PB-']));

            $nota_pembelian->no_nota = $id_generator;
            $nota_pembelian->nota_pemesanan_id = $idPemesanan;
            $nota_pembelian->save();

            for ($i = 0; $i < count($itemID); $i++) {

                $inp_id = $itemID[$i];
                $inp_quantity = $quantity[$i];
                $inp_harga = $harga[$i];
                $subTotal += $total[$i];

                $nota_pembelian->barang()->attach($inp_id, [
                    'jumlah' => $inp_quantity, 'harga_beli' => $inp_harga,
                ]);
            }
            $update_harga = nota_pembelian::orderBy('id', 'DESC')->first();
            $update_harga->total_harga = $subTotal;
            $update_harga->save();

            //Update Pemesanan
            $getNotaPemesanan->status_pemesanan = "selesai";
            $getNotaPemesanan->save();
            return redirect()->back()->with('alert', 'Nota pembelian telah dibuat!');
        } else {

            $id_generator = IdGenerator::generate((['table' => 'nota_pembelian', 'field' => 'no_nota', 'length' => 12, 'prefix' => 'PP-']));
            $nota_pembelian->no_nota = $id_generator;
            $nota_pembelian->nota_pemesanan_id = $idPemesanan;
            $nota_pembelian->save();

            for ($i = 0; $i < count($itemID); $i++) {

                $inp_id = $itemID[$i];
                $inp_quantity = $quantity[$i];
                $inp_harga = $harga[$i];
                $subTotal += $total[$i];

                $nota_pembelian->produk()->attach($inp_id, [
                    'jumlah' => $inp_quantity, 'harga_beli' => $inp_harga,
                ]);
            }
            $update_harga = nota_pembelian::orderBy('id', 'DESC')->first();
            $update_harga->total_harga = $subTotal;
            $update_harga->save();

            //Update Pemesanan
            $getNotaPemesanan->status_pemesanan = "selesai";
            $getNotaPemesanan->save();

            return redirect()->back()->with('alert', 'Nota pembelian telah dibuat!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nota = nota_pembelian::find($id);
        $metode = jenis_pembayaran::all();
        return response()->json(array(
            'msg' => view('persediaan.pembelian_detail_nota', compact('nota', 'metode'))->render()
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
    public function update(Request $request)
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
    public function getItem(Request $request)
    {
        //
        $id = $request->get('id');
        $pemesanan = nota_pemesanan::where('no_nota', $id)->first();

        return response()->json(array(
            'msg' => view('persediaan.pembelian_get_item_table', compact('pemesanan'))->render()
        ), 200);
    }
    public function tambahPembayaran(Request $request){

        // dd($request);

        $nota_id = $request->get('no_nota');
        $nota_pembelian = nota_pembelian::where('no_nota',$nota_id)->first();
        $id =$nota_pembelian->id;
        $jumlah_bayar = str_replace('.','',$request->get('jumlah_bayar'));
        $metode_bayar = $request->get('metode');
        $tagihanRp = $request->get('tagihan');
        $tagihan = str_replace('.','',$tagihanRp);


        $pembayaran = new pembayaran();
        $pembayaran->tagihan = $tagihan;
        $pembayaran->jenis_pembayaran_id = $metode_bayar;
        $pembayaran->total_bayar = $jumlah_bayar;
        if(($tagihan - $jumlah_bayar) < 0){
            $pembayaran->sisa_tagihan =0;
        }
        else{
            $pembayaran->sisa_tagihan = $tagihan - $jumlah_bayar;
        }

        $pembayaran->save();
        // $p = pembayaran::find(3);

        $pembayaran->nota_pembelian()->attach($id);

        if($tagihan <= $jumlah_bayar){
            if($nota_pembelian ->status_pembelian == 'belum dibayar'){
                $nota_pembelian ->status_pembelian = 'selesai';
                $nota_pembelian->save();
            }
            else{
                $nota_pembelian ->status_pembelian = 'belum diterima';
                $nota_pembelian->save();
            }
        }

        return redirect()->back()->with('alert', 'Pembayaran Ditambahan');
    }
}
