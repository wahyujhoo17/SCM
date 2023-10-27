<?php

namespace App\Http\Controllers;
use App\Models\nota_pemesanan;
use App\Models\pemasok;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Nota_pemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nota = nota_pemesanan::all();
        $pemasok = pemasok::all();

        // return view('pegawai.jabatan', ['data'=> $nb]);
        return view('persediaan.pemesanan_stok', ['NP' => $nota, 'PM' => $pemasok]);
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

        //
        $jenis = $request->get('jenis_barang');
        $pemasok = $request->get('pemasok');
        //add produk
        $itemID = $request->get('productId');
        $quantity = $request->get('quantity');
        $harga = $request->get('price');
        $total = $request->get('total');
        //
        $totalHarga = 0;
        if ($jenis == "Barang") {
            $id_generator = IdGenerator::generate((['table' => 'nota_pemesanan', 'field' => 'no_nota', 'length' => 9, 'prefix' => 'NB-']));

            $nota_barang = new nota_pemesanan();
            $nota_barang->pemasok_id = $pemasok;
            $nota_barang->status_pemesanan = 'diproses';
            $nota_barang->no_nota = $id_generator;
            $nota_barang->user_id = Auth::user()->id;
            $nota_barang->total_harga = 0;
            $nota_barang->save();
            for ($i = 0; $i < count($itemID); $i++) {

                $inp_id = $itemID[$i];
                $inp_quantity = $quantity[$i];
                $inp_harga = $harga[$i];
                $totalHarga += $total[$i];

                $nota_barang->barang()->attach($inp_id, [
                    'jumlah_barang' => $inp_quantity, 'harga_beli' => $inp_harga,
                ]);
            }
            // print_r($totalHarga);
            $update_harga = nota_pemesanan::orderBy('id', 'DESC')->first();;
            $update_harga->total_harga = $totalHarga;
            $update_harga->save();
            return redirect()->back()->with('alert', 'Data berhasil ditambahkan!');
        } else {
            $id_generator = IdGenerator::generate((['table' => 'nota_pemesanan', 'field' => 'no_nota', 'length' => 9, 'prefix' => 'NP-']));

            $nota_produk = new nota_pemesanan();
            $nota_produk->pemasok_id = $pemasok;
            $nota_produk->status_pemesanan = 'diproses';
            $nota_produk->no_nota = $id_generator;
            $nota_produk->user_id = Auth::user()->id;
            $nota_produk->total_harga = 0;
            $nota_produk->save();

            for ($i = 0; $i < count($itemID); $i++) {

                $inp_id = $itemID[$i];
                $inp_quantity = $quantity[$i];
                $inp_harga = $harga[$i];
                $totalHarga += $total[$i];

                $nota_produk->produk()->attach($inp_id, [
                    'jumlah_barang' => $inp_quantity, 'harga_beli' => $inp_harga,
                ]);
            }

            $update_harga = nota_pemesanan::orderBy('id', 'DESC')->first();;
            $update_harga->total_harga = $totalHarga;
            $update_harga->save();
            return redirect()->back()->with('alert', 'Data berhasil ditambahkan!');
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
        //
        //
        $spitID = explode('-' , $id);
        if($spitID[0] == 'NP'){

            $nota = nota_pemesanan::where('no_nota', $id)->first();
            $status = "NP";
// 
            return response()->json(array(
                'view' => view('persediaan.detail_nota_modal' , compact('nota', 'status'))->render()
            ),200);
        }
        else{
            $nota = nota_pemesanan::where('no_nota', $id)->first();
            $status = "NB";

                return response()->json(array(
                    'view' => view('persediaan.detail_nota_modal' , compact('nota', 'status'))->render()
                ),200);
        }
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
        // dd($id);
        $notaBatal = nota_pemesanan::find($id);
        $notaBatal->status_pemesanan = 'batal';
        $notaBatal->save();

        return redirect()->back()->with('alert', 'Nota Pemesanan '.$notaBatal->no_nota . ' telah dibatalkan');
    }
    public function getItem(Request $request){
        //
        $pemasokID = $request->get('id');
        $jenis = $request->get('jenis');
        $pemasok = pemasok::find($pemasokID);
        $item ='';

        if($jenis == 'Barang'){
            $item = $pemasok->barang;
        }
        else{
            $item = $pemasok->produk;
        }
        return response()->json(array(
            'msg' => $item
        ));
    }
}
