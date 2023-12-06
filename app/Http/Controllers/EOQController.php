<?php

namespace App\Http\Controllers;

use App\Models\eoq_ss;
use App\Models\nota_pembelian;
use App\Models\penjualan;
use App\Models\pesanan;
use App\Models\produk;
use App\Models\produksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EOQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //SS DAN EOQ PRODUK
        $dataDatabase = eoq_ss::find(1);

        $awalTahunLalu = Carbon::parse($dataDatabase->tanggal_awal);
        $akhirTahunLalu = Carbon::parse($dataDatabase->tanggal_akhir);

        $tanggal = [$awalTahunLalu, $akhirTahunLalu];

        $pemesananData = DB::table('pesanan')
            ->join('detail_pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->select('detail_pesanan.produk_id', DB::raw('SUM(detail_pesanan.jumlah) as total_terjual'))
            ->whereBetween('pesanan.tanggal', [$awalTahunLalu, $akhirTahunLalu])
            ->groupBy('detail_pesanan.produk_id');

        $penjualanData = DB::table('nota_penjualan')
            ->join('detail_nota_penjualan', 'nota_penjualan.id', '=', 'detail_nota_penjualan.nota_penjualan_id')
            ->select('detail_nota_penjualan.produk_id', DB::raw('SUM(detail_nota_penjualan.jumlah) as total_terjual'))
            ->whereBetween('nota_penjualan.tanggal', [$awalTahunLalu, $akhirTahunLalu])
            ->groupBy('detail_nota_penjualan.produk_id');

        $pemesananSql = $pemesananData->toSql();
        $penjualanSql = $penjualanData->toSql();

        $produkTerjual = DB::table(DB::raw("($pemesananSql UNION ALL $penjualanSql) as combined"))
            ->mergeBindings($pemesananData)
            ->mergeBindings($penjualanData)
            ->select('produk_id', DB::raw('SUM(total_terjual) as total_terjual'))
            ->groupBy('produk_id')
            ->get();

        //SS
        $salesData = DB::table(DB::raw('(
            SELECT produk_id, jumlah FROM detail_nota_penjualan
            UNION ALL
            SELECT produk_id, jumlah FROM detail_pesanan
        ) AS combined'))
            ->select('produk_id', DB::raw('AVG(jumlah) as total_penjualan'), DB::raw('STDDEV(jumlah) as std_deviation'))
            ->groupBy('produk_id')
            ->get();


        function calculateEOQ($D, $S, $H)
        {
            // Menghitung EOQ berdasarkan pesanan yang masuk
            $EOQ = sqrt((2 * $D * $S) / ($H * 0.25));
            return $EOQ;
        }

        $listEOQ = [];

        foreach ($produkTerjual as $tot) {
            $produk = produk::find($tot->produk_id);
            $harga_produk = $produk->harga_beli;
            $averagePrice = round(nota_pembelian::avg('biaya_pengiriman'));

            $EOQ = calculateEOQ($tot->total_terjual, $averagePrice, $harga_produk);
            $listEOQ[$produk->id] = [round($EOQ), $produk, $tot->total_terjual];

            $produk->EOQ = round($EOQ);
            $produk->save();
        }

        //SAFETY STOK
        $safetyStockResults = [];

        function calculateSafetyStock($Z, $sigma, $L, $averageDemand)
        {
            // Rumus safety stock
            $safetyStock = ($Z * $sigma * $L) + $averageDemand;
            return $safetyStock;
        }

        function hitungDeviasiStandar($data)
        {
            // Hitung rata-rata
            $rata_rata = array_sum($data) / count($data);

            // Hitung jumlah kuadrat selisih antara setiap nilai dan rata-rata
            $selisih_kuadrat = array_map(function ($x) use ($rata_rata) {
                return pow($x - $rata_rata, 2);
            }, $data);

            // Hitung rata-rata dari selisih kuadrat
            $rata_rata_selisih_kuadrat = array_sum($selisih_kuadrat) / count($selisih_kuadrat);

            // Hitung akar kuadrat dari rata-rata selisih kuadrat
            $deviasi_standar = sqrt($rata_rata_selisih_kuadrat);

            return $deviasi_standar;
        }

        foreach ($salesData as $sale) {

            $produk = produk::find($sale->produk_id);
            $data = [];
            foreach ($produk->nota_penjualan as $penjualan) {
                $data[] = $penjualan->pivot->jumlah;
            }
            $ssData = eoq_ss::find(1);
            //RATA RATA PERMINTAAN
            $tanggal_sekarang = Carbon::now();
            $tanggal_mundur = $tanggal_sekarang->copy()->subDays($ssData->Ltime);

            $rPermintaan = DB::table('pesanan')
            ->join('detail_pesanan', 'pesanan.id', '=', 'detail_pesanan.pesanan_id')
            ->select('detail_pesanan.produk_id', DB::raw('SUM(detail_pesanan.jumlah) /'.$ssData->Ltime.' as total_terjual'))
            ->whereBetween('pesanan.tanggal', [$tanggal_mundur, $tanggal_sekarang])
            ->where('detail_pesanan.produk_id' ,'=' , $sale->produk_id)
            ->groupBy('detail_pesanan.produk_id')->first();

            $Z = $ssData->Zscore; // Nilai dari distribusi normal standar untuk tingkat layanan 95%
            $sigma =hitungDeviasiStandar($data); // Deviasi standar
            $L = $ssData->Ltime; // Lead time dalam satuan waktu yang sama dengan deviasi standar (misalnya, hari)
            if($rPermintaan != null){
                $averageDemand = $rPermintaan->total_terjual; // Rata-rata permintaan
            }
            else{
                $averageDemand = 0; // Rata-rata permintaan
            }

            $safetyStockResult = calculateSafetyStock($Z, $sigma, $L, $averageDemand);
            $safetyStockResults[$sale->produk_id] = [round($safetyStockResult), $produk->nama, $produk->produk_id];

            $produk->SS = round($safetyStockResult);
            $produk->save();
        }

        //SS DAN EOQ BARANG

        return view('persediaan.EOQ', ['ss' => $safetyStockResults, 'eoq' => $listEOQ, 'tanggal' => $tanggal]);
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
