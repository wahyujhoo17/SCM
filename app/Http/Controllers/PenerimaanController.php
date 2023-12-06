<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\jenis_pembayaran;
use App\Models\pembayaran;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $showModal = false;
        $idG = IdGenerator::generate((['table' => 'pembayaran', 'field' => 'nomor', 'length' => 17, 'prefix' => 'INVPAY-' . date('y')]));
        $id = "";
        $jenisPembayaran = jenis_pembayaran::all();
        $invoice = invoice::where('status', '!=', 'Lunas')->get();
        //
        $pembayaran = pembayaran::where("nomor", "LIKE", "\\" . "INVPAY-" . "%")->get();
        return view('invoice.daftar_penerimaan', compact('showModal', 'invoice', 'id', 'idG', 'jenisPembayaran', 'pembayaran'));
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
        $idInvoice = $request->invoice;
        $nomorPenerimaan = $request->nomorPenerimaan;
        $tagihan = str_replace(['.', 'Rp '], '', $request->sisaTagihan);
        $jenisPembayaran = $request->jenis_pembayaran;
        $nominalBayar = str_replace('.', '', $request->nominal_bayar);
        $keterangan = $request->keterangan;
        //SELECT INVOICE BY ID
        $invoice = invoice::find($idInvoice);
        //ADD DATA ON PEMBAYARAN
        $pembayaran = new pembayaran();
        $pembayaran->nomor = $nomorPenerimaan;
        $pembayaran->total_bayar = $nominalBayar;
        $pembayaran->tagihan = $tagihan;
        $pembayaran->jenis_pembayaran_id = $jenisPembayaran;
        $pembayaran->keterangan = $keterangan;

        if ($nominalBayar >= $tagihan) {
            $pembayaran->sisa_tagihan = 0;
            //UPADT DATA INVOICE
            $invoice->tagihan = 0;
            $invoice->status = "Lunas";

            if ($invoice->nomor_pesanan != null) {
                //Ubah Status Pesanan
                $pesanan = pesanan::where('nomor', $invoice->nomor_pesanan)->first();
                if ($pesanan != null) {
                    if($pesanan->pengiriman != '[]'){
                        $pesanan->status_pesanan = "Selesai";
                        $pesanan->save();
                    }
                    else{
                        $pesanan->status_pesanan = "Menunggu Pengiriman";
                        $pesanan->save();
                    }
                }
            }
        } else {
            $min = $tagihan - $nominalBayar;
            $pembayaran->sisa_tagihan = $min;
            //UPADT DATA INVOICE
            $invoice->tagihan = $min;
        }
        //SAVE INVOICE
        $invoice->save();
        //SAVE PEMBAYARAN
        $pembayaran->save();
        //Add On Many To Many data
        $pembayaran->invoice()->attach($idInvoice);
        //Back To Page
        $showModal = false;
        $idG = IdGenerator::generate((['table' => 'pembayaran', 'field' => 'nomor', 'length' => 13, 'prefix' => 'INVPAY-' . date('y')]));
        $id = "";
        $jenisPembayaran = jenis_pembayaran::all();
        $invoice = invoice::where('status', '!=', 'Lunas')->get();
        $pembayaran = pembayaran::where("nomor", "LIKE", "\\" . "INVPAY-" . "%")->get();

        return view('invoice.daftar_penerimaan', compact('showModal', 'invoice', 'id', 'idG', 'jenisPembayaran', 'pembayaran'))->with('alert', 'Penerimaan berhasil ditambahkan !');
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
        $invoice = invoice::find($id);
        $pelanggan = $invoice->pelanggan->nama;
        return response()->json(array(
            'inv' => $invoice, 'pelanggan' => $pelanggan
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
        $showModal = true;
        $idG = IdGenerator::generate((['table' => 'pembayaran', 'field' => 'nomor', 'length' => 15, 'prefix' => 'INVPAY-' . date('y') . date('d')]));
        $invoice = invoice::where('status', '!=', 'Lunas')->get();
        $jenisPembayaran = jenis_pembayaran::all();
        $pembayaran = pembayaran::where("nomor", "LIKE", "\\" . "INVPAY-" . "%")->get();
        return view('invoice.daftar_penerimaan', compact('showModal', 'invoice', 'id', 'idG', 'jenisPembayaran', 'pembayaran'));
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
