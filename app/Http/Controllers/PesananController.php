<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepesananRequest;
use App\Http\Requests\UpdatepesananRequest;
use App\Models\pelanggan;
use App\Models\pesanan;
use App\Models\produk;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pelanggan = pelanggan::all();
        $pesanan = pesanan::all();
        $produk = produk::all();
        return view('invoice.daftar_pesanan', ['data' => $pesanan, 'pelanggan' => $pelanggan, 'produk' => $produk]);
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
     * @param  \App\Http\Requests\StorepesananRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id_generator = IdGenerator::generate((['table' => 'pesanan', 'field' => 'nomor', 'length' => 12, 'prefix' => 'OR-'.date('y')]));
        $pesanan = new pesanan();
        $pesanan->nomor = $id_generator;
        $pesanan->pelanggan_id = $request->pelanggan;
        $pesanan->total_harga = 0;
        $pesanan->status_pesanan = 'dalam antrian';

        //Cari Alamat
        $pelanggan = pelanggan::find($request->pelanggan);
        $pesanan->alamat_pengiriman =$pelanggan->alamat;
        $pesanan->save();

        //add Item
        $itemID = $request->get('productId');
        $quantity = $request->get('quantity');
        $harga = $request->get('price');
        $total = $request->get('total');
        $subTotal = 0;

        for ($i = 0; $i < count($itemID); $i++) {
            $expload = explode("-" , $itemID[$i]);
            $inp_id = $expload[0];
            $inp_quantity = $quantity[$i];
            $inp_harga = $harga[$i];
            $subTotal += $total[$i];

            $pesanan->produk()->attach($inp_id, [
                'jumlah' => $inp_quantity, 'harga_beli' => $inp_harga,
            ]);
        }

        $update_harga = pesanan::orderBy('id', 'DESC')->first();
        $update_harga->total_harga = $subTotal;
        $update_harga->save();

        return redirect()->back()->with('alert', 'Pesanan telah dibuat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $pesanan = pesanan::find($id);

        return response()->json(array(
            'view' => view('invoice.modal.view' , compact('pesanan'))->render()
        ),200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function edit(pesanan $pesanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepesananRequest  $request
     * @param  \App\Models\pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepesananRequest $request, pesanan $pesanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pesanan = pesanan::where('nomor' , $id)->first();
        $pesanan->status_pesanan = 'Batal';
        $pesanan->save();
        //

        return redirect()->back()->with('alert', 'Pesanan telah dibatalkan!');
    }
}
