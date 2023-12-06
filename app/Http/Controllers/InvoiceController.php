<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Http\Request;
use App\Models\pelanggan;
use App\Models\pesanan;
use App\Models\produk;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $inv = invoice::orderBy('id', 'desc')->first();
        $idG = IdGenerator::generate((['table' => 'invoice', 'field' => 'nomor', 'length' => 13, 'prefix' => 'INV/' . date('y') . $inv->id]));
        $pelanggan = pelanggan::all();
        $pesanan = pesanan::where('status_pesanan', 'dalam antrian')->get();
        $produk = produk::all();
        $invoice = invoice::all();

        //PENGECEKAN JATUH TEMPO
        $ldate = date('Y-m-d');
        foreach($invoice as $iv){
            if($iv->jatuh_tempo <= $ldate && $iv->tagihan >0){
                $iv->status = "Jatuh Tempo";
                $iv->save();
            }
        }

        return view('invoice.daftar_invoice', ['data' => $pesanan, 'pelanggan' => $pelanggan, 'produk' => $produk, 'idG' => $idG, 'invoice' => $invoice]);
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
        $pesanan = $request->rPesanan;
        $nomorInvoice = $request->noInvoice;
        $alamatPengiriman = $request->alamat_pengiriman;
        $tanggalJatuhTempo = $request->tanggalJatuhTempo;
        $keterangan = $request->keterangan;
        $subtotal = str_replace('.', '', $request->subTotal);
        $diskon = str_replace('.', '', $request->diskonValue);
        $persentase = $request->diskon;
        $ongkir = str_replace('.', '', $request->ongkir);
        $total_final = str_replace('.', '', $request->total_final);

        //ADD DATA
        $invoice = new invoice();
        $invoice->nomor = $nomorInvoice;
        $invoice->subTotal = $subtotal;
        $invoice->total = $total_final;
        $invoice->alamat_pengiriman = $alamatPengiriman;
        $invoice->tagihan = $total_final;
        $invoice->jatuh_tempo = $tanggalJatuhTempo;
        $invoice->biaya_pengiriman = $ongkir;
        $invoice->diskon = $persentase."-".$diskon;
        $invoice->keterangan = $keterangan;

        if ($pesanan != null) {
            $pelangganID = $request->rPelanggan;
            $invoice->pelanggan_id = $pelangganID;

            $updatePesanan = pesanan::find($pesanan);
            $invoice->nomor_pesanan = $updatePesanan->nomor;
            $updatePesanan->status_pesanan = 'proses';
            $updatePesanan->save();
            
        } else {
            $pelangganID =explode('-' ,$request->pelanggan ) ;
            $invoice->pelanggan_id = $pelangganID[0];
        }

        $invoice->save();

        //ADD ITEMM
        $produkId = $request->productId;
        $qty = $request->quantity;
        $harga = $request->price;
        $total = $request->total;

        for ($i = 0; $i < count($produkId); $i++) {
            $expload = explode("-" , $produkId[$i]);
            $inp_id = $expload[0];
            $inp_quantity = $qty[$i];
            $inp_harga = $harga[$i];
            $tot = $total[$i];

            $invoice->produk()->attach($inp_id, [
                'jumlah' => $inp_quantity, 'harga' => $inp_harga,'total' => $tot
            ]);
        }

        return redirect()->back()->with('alert', 'Invoice berhasil dibuat !');
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
        $inv = invoice::orderBy('id', 'desc')->first();
        $idG = IdGenerator::generate((['table' => 'invoice', 'field' => 'nomor', 'length' => 13, 'prefix' => 'INV/' . date('y') . $inv->id]));
        $pesanan = pesanan::find($id);

        return response()->json([
            'listTable' => view('invoice.modal.table_item', compact('pesanan'))->render(),
            'view' => view('invoice.modal.tambah_invoice', compact('pesanan', 'idG'))->render()
        ], 200);
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
    public function detailInvoice($id){

        $invoice = invoice::find($id);
        return response()->json([
            'view' => view('invoice.modal.detail_invoice' , compact('invoice'))->render()
        ]);
    }
}
