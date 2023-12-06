<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepengirimanRequest;
use App\Http\Requests\UpdatepengirimanRequest;
use App\Models\gudang;
use App\Models\invoice;
use App\Models\pegawai;
use App\Models\pengiriman;
use App\Models\perputaran_produk;
use App\Models\pesanan;
use DateTime;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $idG = IdGenerator::generate((['table' => 'pengiriman', 'field' => 'nomor', 'length' => 12, 'prefix' => 'EC-' . date('y') . date('d')]));
        $pengiriman = pengiriman::all();
        $pesanan = pesanan::where('status_pesanan', 'proses')->orWhere('status_pesanan','Menunggu Pengiriman')->get();
        $pegawai = pegawai::where('jabatan_id', 4)->get();
        return view('invoice.daftar_pengiriman', ['data' => $pengiriman, 'pesanan' => $pesanan, 'idG' => $idG, 'pengirim' => $pegawai]);
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
     * @param  \App\Http\Requests\StorepengirimanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $idPesanan = $request->pemesanan;
        $pengirim = $request->pengirim;
        $noPengiriman = $request->noPengiriman;
        $tanggal = new DateTime($request->tanggal);
        $produkidAr = $request->productId;
        $qtyAr = $request->quantity;
        $gudangAr = $request->gudang;

        // dd($request);
        //
        $pesanan = pesanan::find($idPesanan);
        //
        $pengiriman = new pengiriman();
        $pengiriman->tanggal_dikirim = $tanggal->format('Y-m-d H:i:s');
        $pengiriman->pesanan_id = $idPesanan;
        $pengiriman->user_id = $pengirim;
        $pengiriman->nomor = $noPengiriman;
        $pengiriman->save();

        //


        for ($i = 0; $i < count($produkidAr); $i++) {
            $idGudang = explode('-', $gudangAr[$i]);
            $idProduk = $produkidAr[$i];
            $jumlah = $qtyAr[$i];
            $gudang = gudang::find($idGudang[0]);
            $gudang->produk()->updateExistingPivot($idProduk, ['jumlah' => (int)$idGudang[1] - (int)$jumlah]);

            //Tambahkan Ke Perputaran Produk
            $pb = new perputaran_produk();
            $pb->status = "keluar";
            $pb->keterangan = "Produk keluar dengan nomor Pengiriman  : " . $noPengiriman;
            $pb->user_id = $pengirim;
            $pb->gudang_id = $gudang->id;
            $pb->save();

            $pb->produk()->attach($idProduk, ['jumlah' => $jumlah]);
        }

        $pesanan->status_pesanan = 'Proses Pengiriaman';
        $pesanan->save();

        return redirect()->back()->with('alert', 'Pengiriman  Berhasil ditambahakan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengiriman  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $pengiriman = pengiriman::find($id);
        $invoice = invoice::where('nomor_pesanan',$pengiriman->pesanan->nomor)->first();
        return response()->json([
            'view' => view('invoice.modal.pengiriman', compact('pengiriman' , 'invoice'))->render(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengiriman  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function edit(pengiriman $pengiriman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepengirimanRequest  $request
     * @param  \App\Models\pengiriman  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $currentDateTime = date('Y-m-d H:i:s');

        $pengiriman = pengiriman::find($id);
        $pengiriman->status = "Selesai";
        $pengiriman->tanggal_diterima = $currentDateTime;
        $pengiriman->keterangan = $request->keterangan;
        $pengiriman->save();

        //Pesanan
        $pesanan = pesanan::find($pengiriman->pesanan_id);
        //Invoice
        $invoice = invoice::where('nomor_pesanan',$pesanan->nomor)->first();
        if($invoice->status == "Belum Lunas"){
            $pesanan->status_pesanan = "Menunggu Pelunasan";
        }
        else{
            $pesanan->status_pesanan = "Selesai";
        }
        $pesanan->save();

        return redirect()->back()->with('berhasil', 'Pengiriman  Berhasil ditambahakn!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengiriman  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function destroy(pengiriman $pengiriman)
    {
        //
    }

    public function getPesanan($id)
    {

        $pesanan = pesanan::find($id);
        $invoice = invoice::where('nomor_pesanan', $pesanan->nomor)->first();
        return response()->json([
            'pelanggan' => $pesanan->pelanggan,
            'invoice' => $invoice,
            'listTable' => view('invoice.modal.table_item_kirim', compact('pesanan'))->render(),
        ]);
    }
}
