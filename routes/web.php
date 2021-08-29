<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', function () {
	return view('login');
})->name('login')->middleware('guest');


Route::get('/register', function () {
	return view('register');
})->name('register')->middleware('guest');

//proses register
Route::post('proses-register', 'AuthController@proses_register')->name('proses-register')->middleware('guest');

//proses login
Route::post('proses-login','AuthController@proses_login')->name('proses-login')->middleware('guest');



//Pengunjung
Route::get('/', 'PengunjungController@landingpage')->name('landingpage-pengunjung');
Route::get('/pengunjung-get_paket_wisata/{id}','PengunjungController@get_paket_wisata')->name('pengunjung-get_paket_wisata');
Route::group(['middleware' => ['auth', 'pengunjung']],function(){
	Route::get('/pengunjung-data_pemesanan', 'PengunjungController@index')->name('pengunjung-data_pemesanan'); 
	Route::get('/pengunjung-tambah_pesanan', 'PengunjungController@tambah_pesanan')->name('pengunjung-tambah_pesanan'); 
	Route::get('/pengunjung-data_pembayaran', 'PengunjungController@data_pembayaran')->name('pengunjung-data_pembayaran'); 
	Route::get('/pengunjung-tambah_pembayaran', 'PengunjungController@tambah_pembayaran')->name('pengunjung-tambah_pembayaran'); 
	Route::get('/pengunjung-profil', 'PengunjungController@profil')->name('pengunjung-profil'); 
	Route::post('/pengunjung-proses_tambah_pesanan', 'PengunjungController@proses_tambah_pesanan')->name('pengunjung-proses_tambah_pesanan');
	Route::post('/pengunjung-proses_tambah_pembayaran', 'PengunjungController@proses_tambah_pembayaran')->name('pengunjung-proses_tambah_pembayaran');
	Route::post('/pengunjung-batalkan_pesanan/{id}','PengunjungController@batalkan_pesanan')->name('pengunjung-batalkan_pesanan');
	Route::put('/pengunjung-proses_ganti_foto_profil/{id}', 'PengunjungController@proses_ganti_foto_profil')->name('pengunjung-proses_ganti_foto_profil');
	Route::post('/pengunjung-pelunasan_pembayaran/{id}','PengunjungController@pelunasan_pembayaran')->name('pengunjung-pelunasan_pembayaran');


});


//Admin
Route::get('/admin-get_paket_belum_bayar/{id_user}','AdminController@get_paket_belum_bayar')->name('admin-get_paket_belum_bayar');
Route::get('/admin-get_paket_wisata/{id}','AdminController@get_paket_wisata')->name('admin-get_paket_wisata');
Route::group(['middleware' => ['auth', 'admin']],function(){
	Route::get('/admin-beranda', 'AdminController@index')->name('admin-beranda');
	Route::get('/admin-beranda_paket', 'AdminController@index2')->name('admin-beranda_paket'); 
	Route::get('/admin-beranda_pendapatan', 'AdminController@index3')->name('admin-beranda_pendapatan');  
	Route::get('/admin-data_guide', 'AdminController@data_guide')->name('admin-data_guide');
	Route::get('/admin-data_pengunjung', 'AdminController@data_pengunjung')->name('admin-data_pengunjung');
	Route::get('/admin-data_paket_wisata', 'AdminController@data_paket_wisata')->name('admin-data_paket_wisata');
	Route::get('/admin-data_paket_wisata_nonaktif', 'AdminController@data_paket_wisata_nonaktif')->name('admin-data_paket_wisata_nonaktif');
	Route::get('/admin-data_pemesanan_pengunjung', 'AdminController@data_pemesanan_pengunjung')->name('admin-data_pemesanan_pengunjung');
	Route::get('/admin-data_pembayaran_pengunjung', 'AdminController@data_pembayaran_pengunjung')->name('admin-data_pembayaran_pengunjung');
	Route::get('/admin-galeri', 'AdminController@galeri')->name('admin-galeri');
	Route::post('/admin-tambah_guide', 'AdminController@tambah_guide')->name('admin-tambah_guide');
	Route::post('/admin-tambah_pengunjung', 'AdminController@tambah_pengunjung')->name('admin-tambah_pengunjung');
	Route::post('/admin-tambah_paket_wisata', 'AdminController@tambah_paket_wisata')->name('admin-tambah_paket_wisata');
	Route::post('/admin-hapus_data_guide/{id}','AdminController@hapus_data_guide')->name('admin-hapus_data_guide');
	Route::post('/admin-nonaktif_data_paket_wisata/{id}','AdminController@nonaktif_data_paket_wisata')->name('admin-nonaktif_data_paket_wisata');
	Route::post('/admin-proses_update_paket_wisata/{id}','AdminController@proses_update_paket_wisata')->name('admin-proses_update_paket_wisata');
	Route::post('/admin-aktif_data_paket_wisata/{id}','AdminController@aktif_data_paket_wisata')->name('admin-aktif_data_paket_wisata');
	Route::post('/admin-proses_tambah_pesanan', 'AdminController@proses_tambah_pesanan')->name('admin-proses_tambah_pesanan');
	Route::post('/admin-proses_tambah_pembayaran', 'AdminController@proses_tambah_pembayaran')->name('admin-proses_tambah_pembayaran');
	Route::post('/admin-verifikasi_pembayaran/{id}','AdminController@verifikasi_pembayaran')->name('admin-verifikasi_pembayaran');
	Route::post('/admin-batalkan_pesanan/{id}','AdminController@batalkan_pesanan')->name('admin-batalkan_pesanan');
	Route::get('/admin-laporan_pengunjung', 'AdminController@laporan_pengunjung')->name('admin-laporan_pengunjung');
	Route::get('/admin-laporan_pemesanan_paket', 'AdminController@laporan_pemesanan_paket')->name('admin-laporan_pemesanan_paket');
	Route::get('/admin-laporan_pendapatan', 'AdminController@laporan_pendapatan')->name('admin-laporan_pendapatan');
	Route::post('/admin-tambah_galeri', 'AdminController@tambah_galeri')->name('admin-tambah_galeri');
	Route::post('/admin-hapus_data_galeri/{id}','AdminController@hapus_data_galeri')->name('admin-hapus_data_galeri');
	Route::get('/admin-profil', 'AdminController@admin_profil')->name('admin-profil'); 
	Route::put('/admin-proses_ganti_foto_profil_admin/{id}', 'AdminController@proses_ganti_foto_profil_admin')->name('admin-proses_ganti_foto_profil_admin');
	Route::post('/admin-pelunasan_pembayaran/{id}','AdminController@pelunasan_pembayaran')->name('admin-pelunasan_pembayaran');


});


// Guide
Route::group(['middleware' => ['auth', 'guide']],function(){
	Route::get('/guide-beranda', 'GuideController@index')->name('guide-beranda');
	Route::get('/guide-jadwal', 'GuideController@guide_jadwal')->name('guide-jadwal');
	Route::get('/guide-profil', 'GuideController@guide_profil')->name('guide-profil'); 
	Route::put('/guide-proses_ganti_foto_profil_guide/{id}', 'GuideController@proses_ganti_foto_profil_guide')->name('guide-proses_ganti_foto_profil_guide');
});


// Kepala Desa
Route::group(['middleware' => ['auth', 'kepala_desa']],function(){
	Route::get('/kepala_desa-beranda', 'KepalaDesaController@index')->name('kepala_desa-beranda');
	Route::get('/kepala_desa-laporan', 'KepalaDesaController@laporan')->name('kepala_desa-laporan'); 
	Route::get('/kepala_desa-laporan_pengunjung', 'KepalaDesaController@laporan_pengunjung')->name('kepala_desa-laporan_pengunjung');
	Route::get('/kepala_desa-laporan_pemesanan_paket', 'KepalaDesaController@laporan_pemesanan_paket')->name('kepala_desa-laporan_pemesanan_paket');
	Route::get('/kepala_desa-laporan_pendapatan', 'KepalaDesaController@laporan_pendapatan')->name('kepala_desa-laporan_pendapatan');
	Route::get('/kepala_desa-profil', 'KepalaDesaController@kepala_desa_profil')->name('kepala_desa-profil'); 
	Route::put('/kepala_desa-proses_ganti_profil_kades/{id}', 'KepalaDesaController@proses_ganti_profil_kades')->name('kepala_desa-proses_ganti_profil_kades');
	Route::get('/kepala_desa-laporan_berkala_pengunjung', 'KepalaDesaController@laporan_berkala_pengunjung')->name('kepala_desa-laporan_berkala_pengunjung');
	Route::get('/kepala_desa-laporan_berkala_pemesanan_paket', 'KepalaDesaController@laporan_berkala_pemesanan_paket')->name('kepala_desa-laporan_berkala_pemesanan_paket');
	Route::get('/kepala_desa-laporan_berkala_pendapatan', 'KepalaDesaController@laporan_berkala_pendapatan')->name('kepala_desa-laporan_berkala_pendapatan');

});


//logout
Route::get('logout-pengunjung', 'AuthController@logout')->name('logout-pengunjung')->middleware(['pengunjung', 'auth']);
Route::get('logout-admin', 'AuthController@logout')->name('logout-admin')->middleware(['admin', 'auth']);
Route::get('logout-guide', 'AuthController@logout')->name('logout-guide')->middleware(['guide', 'auth']);
Route::get('logout-kepala_desa', 'AuthController@logout')->name('logout-kepala_desa')->middleware(['kepala_desa', 'auth']);
