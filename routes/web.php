<?php

use App\Http\Controllers\areaGudangController;
use App\Http\Controllers\BarangMentahController;
use App\Http\Controllers\daftar_barang_mentahContoller;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KategoriPelangganController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\konfirmasiGudangController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\MutasiStokController;
use App\Http\Controllers\Nota_pembelianController;
use App\Http\Controllers\Nota_pemesananController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\perputaran_stokController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\produkController;
use App\Http\Controllers\StokOpnameController;
use App\Models\kategori_pelanggan;
use App\Models\pesanan;
use App\Models\stok_opname;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Product
Route::resource('/produk', produkController::class);
Route::resource('/kategori', KategoriProdukController::class);
Route::post('/produks/getUpdate', [produkController::class, 'get_Update'])->name('get_update');

//----- Persediaan -----//
//Pemasok
Route::resource('/pemasok', PemasokController::class);
Route::post('/pemasok-item', [PemasokController::class, 'addItem'])->name('add_item_pemasok');
Route::post('/pemasok-hapus-item', [PemasokController::class, 'hapusItem'])->name('hapus_item_pemasok');
//pembelian
Route::resource('/pembelian', Nota_pembelianController::class);
Route::post('/pembelian/getItem', [Nota_pembelianController::class, 'getItem'])->name('getItemPembelian');
Route::post('/pembelian/pembayaran', [Nota_pembelianController::class, 'tambahPembayaran'])->name('tambahPembayaran');
//pemesanan
Route::post('/pemesanan/getItem', [Nota_pemesananController::class, 'getItem'])->name('getItem');
Route::resource('/pemesanan', Nota_pemesananController::class);
//Gudang
Route::resource('/gudang', GudangController::class);
Route::resource('/konfirmasi', konfirmasiGudangController::class);
Route::resource('/perputaran-stok', perputaran_stokController::class);
//Stok
Route::resource('/daftar-barang-mentah', BarangMentahController::class);
Route::resource('/stok-opname', StokOpnameController::class);
Route::get('pengerjaan-opname/{id}', [StokOpnameController::class, 'pengerjaan'])->name('pengerjaan_opname');
Route::post('/simpan-pengecekan-stok/{id}', [StokOpnameController::class, 'simpanPengecekan'])->name('simpanPengecekan');
Route::get('/print-list/{id}', [StokOpnameController::class, 'getDataForPrint'])->name('print-list');
Route::get('/view-stokopname/{id}', [StokOpnameController::class, 'view'])->name('view-stokOpname');
Route::post('/review/{id}', [StokOpnameController::class, 'reviewAcc'])->name('reviewAcc');
//Mutasi Stok
Route::resource('/mutasi-stok', MutasiStokController::class);
//Pelanggan
Route::resource('/pelanggan', PelangganController::class);
Route::resource('/kategori_pelanggan', KategoriPelangganController::class);
//Pegawai
Route::resource('/pegawai', PegawaiController::class);
Route::resource('/jabatan', JabatanController::class);
//Outlet
Route::resource('/penjualan', PenjualanController::class);
Route::get('/daftar-penjualan', [PenjualanController::class, 'daftarPenjualan'])->name('daftar-penjualan');
Route::post('/detail-penjualan', [PenjualanController::class, 'getDetail'])->name('getDetail');
//LAPORAN
Route::resource('/laporan', laporanController::class);
Route::get('/laporan-harian', [laporanController::class, 'laporanHarian'])->name('laporanHarian');
Route::get('/laporan-produk', [laporanController::class, 'laporanProduk'])->name('laporanProduk');
//Invoice
Route::resource('/daftar-pesanan' , PesananController::class);
Route::resource('/daftar-invoice' , InvoiceController::class);
Route::resource('/daftar-penerimaan' , PenerimaanController::class);
Route::get('/detail-invoice/{id}' , [InvoiceController::class , 'detailInvoice'])->name('detailInv');