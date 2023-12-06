<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreproduksiRequest;
use App\Http\Requests\UpdateproduksiRequest;
use App\Models\barang_mentah;
use App\Models\gudang;
use App\Models\kelebihan_barang;
use App\Models\pegawai;
use App\Models\perputaran_barang;
use App\Models\produk;
use App\Models\produksi;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $idG = IdGenerator::generate((['table' => 'produksi', 'field' => 'nomor', 'length' => 13, 'prefix' => 'PRD/']));
        $produk = produk::all();
        $pegawai = pegawai::where('jabatan_id', 7)->get();
        $produksi = produksi::all();
        return view('produksi.daftar-produksi', compact('produk', 'idG', 'pegawai', 'produksi'));
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
     * @param  \App\Http\Requests\StoreproduksiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $produkid = $request->produk;
        $nomorProduksi = $request->kode;
        $pegawai_id = $request->pegawai;
        $kuantitas = $request->kuantitas;
        //ACUANNN
        $nomorBarang = $request->nomor;
        $jumlahBarang = $request->jumlah;
        $gudang = $request->gudang;

        $produksi = new produksi();
        $produksi->jumlah_produksi = $kuantitas;
        $produksi->status_produksi = 'Dalam Antrian';
        $produksi->produk_id = $produkid;
        $produksi->nomor = $nomorProduksi;
        $produksi->user_id = $pegawai_id;
        $produksi->save();

        for ($i = 0; $i < count($nomorBarang); $i++) {
            # code...
            $barang = barang_mentah::where('nomor', $nomorBarang[$i])->first();
            $produksi->barang()->attach($barang->id, ['jumlah' => $jumlahBarang[$i], 'gudang_id' => explode('-', $gudang[$i])[0]]);

            # Perputaran Barang
            $perputaran_barang = new perputaran_barang();
            $perputaran_barang->status = 'keluar';
            $perputaran_barang->keterangan = 'Barang keluar berdasarkan Produksi No: ' . $nomorProduksi;
            $perputaran_barang->gudang_id = explode('-', $gudang[$i])[0];
            $perputaran_barang->user_id = $pegawai_id;
            // $perputaran_barang->save();
            # 
            // $perputaran_barang->barang()->attach($barang->id, ['Jumlah' => $jumlahBarang[$i]]);
            # kurangi data gudang
            $gudangop = gudang::find(explode('-', $gudang[$i])[0]);
            // $gudangop->barang()->updateExistingPivot($barang->id, ['jumlah' => (double)explode('-', $gudang[$i])[1] - (double)$jumlahBarang[$i]]);
        }

        return redirect()->back()->with('alert', 'Produksi Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\produksi  $produksi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $kuantitas = $request->kuantitas;
        $produk = produk::find($id);

        return response()->json(array(
            'msg' => view('produksi.tableAcuan2', compact('produk', 'kuantitas'))->render()
        ), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\produksi  $produksi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk = produk::all();
        $pegawai = pegawai::where('jabatan_id', 7)->get();
        $produksi = produksi::find($id);
        //
        return response()->json(array(
            'msg' => view('produksi.edit-produksi', compact('produksi', 'produk', 'pegawai'))->render()
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateproduksiRequest  $request
     * @param  \App\Models\produksi  $produksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
        $produkid = $request->produk;
        $nomorProduksi = $request->kode;
        $pegawai_id = $request->pegawai;
        $kuantitas = $request->kuantitas;
        //ACUANNN
        $nomorBarang = $request->nomor;
        $jumlahBarang = $request->jumlah;
        $gudang = $request->gudang;

        $produksi = produksi::find($id);
        $produksi->jumlah_produksi = $kuantitas;
        $produksi->status_produksi = 'Dalam Antrian';
        $produksi->produk_id = $produkid;
        $produksi->nomor = $nomorProduksi;
        $produksi->user_id = $pegawai_id;
        $produksi->save();

        $produksi->barang()->sync([]);
        for ($i = 0; $i < count($nomorBarang); $i++) {
            # code...
            $barang = barang_mentah::where('nomor', $nomorBarang[$i])->first();
            $produksi->barang()->attach($barang->id, ['jumlah' => $jumlahBarang[$i], 'gudang_id' => explode('-', $gudang[$i])[0]]);

            # Perputaran Barang
            $perputaran_barang = new perputaran_barang();
            $perputaran_barang->status = 'keluar';
            $perputaran_barang->keterangan = 'Barang keluar berdasarkan Produksi No: ' . $nomorProduksi;
            $perputaran_barang->gudang_id = explode('-', $gudang[$i])[0];
            $perputaran_barang->user_id = $pegawai_id;
            // $perputaran_barang->save();
            # 
            // $perputaran_barang->barang()->attach($barang->id, ['Jumlah' => $jumlahBarang[$i]]);
            # kurangi data gudang
            $gudangop = gudang::find(explode('-', $gudang[$i])[0]);
            // $gudangop->barang()->updateExistingPivot($barang->id, ['jumlah' => (double)explode('-', $gudang[$i])[1] - (double)$jumlahBarang[$i]]);
        }
        return redirect()->back()->with('alert', 'Produksi Berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\produksi  $produksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(produksi $produksi)
    {
        //
    }
    public function acuanProduksi()
    {

        $barangMentah = barang_mentah::all();
        $produk = produk::all();
        return view('produksi.acuan-produksi', compact('barangMentah', 'produk'));
    }

    public function tambahResep(Request $request)
    {
        $produkid = $request->produk;
        $nomor = $request->nomor;
        $param = $request->jumlah;

        //SelectProduk
        $produk = produk::find($produkid);

        // dd($produk->barang);
        if ($produk->barang->isEmpty()) {
            for ($i = 0; $i < count($nomor); $i++) {
                $barang = barang_mentah::where('nomor', $nomor[$i])->first();
                // dd($param);
                $jumlah = explode(' ', $param[$i])[0];
                $satuan = explode(' ', $param[$i])[1];
                $produk->barang()->attach($barang->id, ['jumlah' => $jumlah, 'satuan' => $satuan]);
            }
        } else {
            $barangData = [];
            $produk->barang()->sync($barangData);
            for ($i = 0; $i < count($nomor); $i++) {
                $barang = barang_mentah::where('nomor', $nomor[$i])->first();
                $jumlah = explode(' ', $param[$i])[0];
                $satuan = explode(' ', $param[$i])[1];
                $produk->barang()->attach($barang->id, ['jumlah' => $jumlah, 'satuan' => $satuan]);
            }
        }

        return redirect()->back()->with('alert', 'Berhasil Di konfirmasi');
    }
    function getProduk($id)
    {

        $produk = produk::find($id);

        return response()->json(array(
            'msg' => view('produksi.tableAcuan', compact('produk'))->render()
        ), 200);
    }

    function eksekusi(Request $request, $id)
    {

        $produksi = produksi::find($id);
        $status = $request->status;
        $gudang = gudang::all();
        return response()->json(array(
            'msg' => view('produksi.eksekusi_modal', compact('produksi', 'status', 'gudang'))->render()
        ), 200);
    }

    function tambahkan(Request $request)
    {
        $idProduksi = $request->produksi;
        $currentDate = date("Y-m-d H:i:s");

        $produksi = produksi::find($idProduksi);

        if ($produksi->status_produksi == 'Dalam Antrian') {
            $produksi->tanggal_mulai = $currentDate;
            $produksi->status_produksi = "Eksekusi";

            foreach ($produksi->barang as $pb) {
                // dd($pb);
                # Perputaran Barang
                $perputaran_barang = new perputaran_barang();
                $perputaran_barang->status = 'keluar';
                $perputaran_barang->keterangan = 'Barang keluar berdasarkan Produksi No: ' . $produksi->nomor;
                $perputaran_barang->gudang_id = $pb->pivot->gudang_id;
                $perputaran_barang->user_id = $produksi->user_id;
                $perputaran_barang->save();

                $perputaran_barang->barang()->attach($pb->id, ['jumlah' => $pb->pivot->jumlah]);

                $gudangop = gudang::find($pb->pivot->gudang_id);
                $stokGd = $gudangop->barang()->find($pb->id);
                $gudangop->barang()->updateExistingPivot($pb->id, ['jumlah' => (float)$stokGd->pivot->jumlah - (float)$pb->pivot->jumlah]);
            }
        } else {
            $produksi->tanggal_selesai = $currentDate;
            $produksi->status_produksi = "Konfirmasi Gudang";
            $nomorBarang = $request->id;
            $jumlah = $request->jumlah;
            $produkSelesai = $request->produkJumlah;

            //Kelebihan Barang
            $kelebihan_barang = new kelebihan_barang();
            $kelebihan_barang->keterangan = $request->keterangan;
            $kelebihan_barang->save();

            $produksi->kelebihan_barang_id = $kelebihan_barang->id;
            $produksi->jumlah_selesai = $produkSelesai;


            for ($i = 0; $i < count($nomorBarang); $i++) {
                $barang = barang_mentah::where('nomor', $nomorBarang[$i])->first();

                //TAMBAHKAN BARANG LEBIH KE GUDANG KEMBALI
                $gudang_id = $barang->produksi()->find($produksi->id)->pivot->gudang_id;

                $perputaran_barang = new perputaran_barang();
                $perputaran_barang->status = 'masuk';
                $perputaran_barang->keterangan = 'Barang masuk dari kelebihan produksi berdasarkan No.Produksi ' . $produksi->nomor;
                $perputaran_barang->gudang_id = $gudang_id;
                $perputaran_barang->user_id = $produksi->user_id;
                $perputaran_barang->save();

                $perputaran_barang->barang()->attach($barang->id, ['jumlah' => $jumlah[$i]]);
                //Update Stok Pada Gudang
                $gudangop = gudang::find($gudang_id);
                $stokGd = $gudangop->barang()->find($barang->id);
                $gudangop->barang()->updateExistingPivot($barang->id, ['jumlah' => (float)$stokGd->pivot->jumlah + (float)$jumlah[$i]]);

                //Tambahkan Kelebihan Barang Detail
                $kelebihan_barang->barang()->attach($barang->id, ['jumlah' => $jumlah[$i]]);
            }
            // dd($nomorBarang);
        }
        $produksi->save();

        return redirect()->back()->with('alert', 'Berhasil Di Eksekusi');
    }
}
