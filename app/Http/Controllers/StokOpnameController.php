<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storestok_opnameRequest;
use App\Http\Requests\Updatestok_opnameRequest;
use App\Models\gudang;
use App\Models\mutasi_stok;
use App\Models\pegawai;
use App\Models\produk;
use App\Models\stok_opname;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

class StokOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $id_generator = IdGenerator::generate((['table' => 'stok_opname', 'field' => 'nomor', 'length' => 15, 'prefix' => 'SPK/' . date('m') . date('y') . "/"]));

        $gudang = gudang::all();
        $user = pegawai::where('jabatan_id', 2)->get();
        $stok_opname = stok_opname::orderBy('id', 'DESC')->get();

        // dd($stok_opname);

        return view('persediaan.stok.stok_Opname', ['gudang' => $gudang, 'user' => $user, 'spk' => $id_generator, 'stok_opname' => $stok_opname]);
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
     * @param  \App\Http\Requests\Storestok_opnameRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        //
        $id_generator = IdGenerator::generate((['table' => 'stok_opname', 'field' => 'nomor', 'length' => 15, 'prefix' => 'SPK/' . date('m') . date('y') . "/"]));

        $so = new stok_opname();
        $so->nomor = $id_generator;
        $so->tanggal_mulai = $request->get('tanggal_mulai');
        $so->keterangan = $request->get('keterangan');
        $so->user_id = $request->get('penanggung_jawab');
        $so->gudang_id = $request->get('pilihan_nama');
        $so->save();

        return redirect()->back()->with('alert', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\stok_opname  $stok_opname
     * @return \Illuminate\Http\Response
     */
    public function show(stok_opname $stok_opname)
    {
        //
        return response()->json(array(
            'sp' => $stok_opname
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\stok_opname  $stok_opname
     * @return \Illuminate\Http\Response
     */
    public function edit(stok_opname $stok_opname)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatestok_opnameRequest  $request
     * @param  \App\Models\stok_opname  $stok_opname
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $SPK = stok_opname::find($id);

        $SPK->tanggal_mulai = $request->get('tanggal_mulai');
        $SPK->keterangan = $request->get('keterangan');
        $SPK->user_id = $request->get('penanggung_jawab');
        $SPK->gudang_id = $request->get('pilihan_nama');
        $SPK->save();

        return redirect()->back()->with('alert', 'Data berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\stok_opname  $stok_opname
     * @return \Illuminate\Http\Response
     */
    public function destroy(stok_opname $stok_opname)
    {
        //
    }

    public function pengerjaan($id)
    {
        try {
            $stok_opname = stok_opname::find($id);

            $gudang = gudang::find($stok_opname->gudang_id);
            $produkGudang = $gudang->produk;

            if ($stok_opname) {
                return view('persediaan.stok.pengerjaan_opname', ['stok_opname' => $stok_opname, 'produk' => $produkGudang]);
            } else {
                abort(404, "Resource not found");
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return view('error.404', compact('errorMessage'));
        }
    }

    public function simpanPengecekan(Request $request, $id)
    {
        $data = $request->get('Vdata');
        $stokOp = stok_opname::find($id);

        foreach ($data as $d) {
            $produk = produk::where('produk_id', $d['id'])->first();
            $namaProduk = $produk->nama;
            $idProduk = $produk->id;

            $gudang = gudang::find($stokOp['gudang_id']);

            foreach ($gudang->produk as $pt) {

                if ($pt->id == $idProduk) {
                    $keterangan = '';
                    if ($d['jumlah'] == $pt->pivot->jumlah) {
                        $keterangan = 'Pas';
                    } elseif ($pt->pivot->jumlah > $d['jumlah']) {
                        $keterangan = 'Kurang';
                    } elseif ($pt->pivot->jumlah < $d['jumlah']) {
                        $keterangan = 'Lebih';
                    }
                    $stokOp->produk()->attach($idProduk, [
                        'jumlah_sistem' => $pt->pivot->jumlah,
                        'jumlah_perhitungan' => $d['jumlah'],
                        'selisih' => $d['jumlah'] - $pt->pivot->jumlah,
                        'keterangan' => $keterangan,
                        'keterangan2' => $d['keterangan'],
                    ]);
                }
            }
        }

        $stokOp->status = 'Perhitungan Selesai';
        $stokOp->tanggal_eksekusi = date("Y-m-d");
        $stokOp->save();

        return response()->json(array(
            'msg' => 'success'
        ), 200);
    }

    public function getDataForPrint($id)
    {

        $stok_opname = stok_opname::find($id);
        $gudang = gudang::find($stok_opname->gudang_id);

        return response()->json(array(
            'view' => view('printPage.printStokOpname', compact('stok_opname', 'gudang'))->render()
        ), 200);
    }
    public function view($id)
    {

        $stok_opname = stok_opname::find($id);
        return response()->json(array(
            'view' => view('persediaan.stok.viewModal_stok_opname', compact('stok_opname'))->render()
        ), 200);
    }

    public function reviewAcc($id)
    {
        $sp = stok_opname::find($id);
        $gudang = gudang::find($sp->gudang_id);

        foreach ($sp->produk as $p) {
            $produk = produk::find($p->id);
            foreach ($gudang->produk as $g) {


                //Tambahkan data pada mutasi stok
                $id_generator = IdGenerator::generate((['table' => 'mutasi_stok', 'field' => 'nomor', 'length' => 12, 'prefix' => 'MS/' . date('m') . date('y') . "/"]));
                $mutasi_stok = new mutasi_stok();
                $mutasi_stok->nomor = $id_generator;
                $mutasi_stok->produk_id = $produk->id;
                $mutasi_stok->stok_sebelum = $g->pivot->jumlah;
                $mutasi_stok->stok_sesudah = $p->pivot->jumlah_perhitungan;
                if ($g->id == $produk->id) {
                    //Kalau Lebih
                    if ($p->pivot->keterangan == 'Lebih') {
                        
                        $mutasi_stok->keterangan = 'Produk ditemukan lebih dari Stok Opname No.'.$sp->nomor.
                        'dengan keterangan'. $p->keterangan2 ;
                        $mutasi_stok->save();
                    }
                    //Kalau kurang
                    elseif ($p->pivot->keterangan == 'Kurang') {
                        $mutasi_stok->keterangan = 'Produk berkurang berdasarkan Stok Opname No.'.$sp->nomor.
                        ' dengan keterangan : '. $p->keterangan2 ;
                        $mutasi_stok->save();
                    }
                    //kalau pas
                    else {
                    }
                }
                //Ubah barang pada databse gudang
                $total = $p->pivot->jumlah_perhitungan;
                $gudang->produk()->updateExistingPivot($produk->id, ['jumlah' => $total]);
            }
        }

        $sp->status = 'selesai';
        $sp->tanggal_selesai = date("Y-m-d");
        $sp->save();

        return response()->json(array(
            'msg' => 'success'
        ), 200);
    }
}
