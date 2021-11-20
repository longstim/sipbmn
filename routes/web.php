<?php

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


Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/adminlte', function () {
    return view('admin/adminlte');
});


//Pegawai
Route::get('pegawai', 'PegawaiController@daftarpegawai');

Route::get('profilpegawai/{id_pegawai}', 'PegawaiController@profilpegawai');

Route::get('tambahkodearsip', 'KodeArsipController@tambahkodearsip');

Route::post('prosestambahkodearsip', 'KodeArsipController@prosestambahkodearsip');

Route::get('ubahkodearsip/{id_kodearsip}','KodeArsipController@ubahkodearsip');

Route::post('prosesubahkodearsip','KodeArsipController@prosesubahkodearsip');

Route::get('hapuskodearsip/{id_kodearsip}','KodeArsipController@hapuskodearsip');


//Lembur Pegawai
Route::get('lembur', 'LemburController@daftarlembur');

Route::get('tambahlembur', 'LemburController@tambahlembur');

Route::post('prosestambahlembur', 'LemburController@prosestambahlembur');

Route::get('ubahlembur/{id_lembur}','LemburController@ubahlembur');

Route::post('prosesubahlembur','LemburController@prosesubahlembur');

Route::get('tambahlemburdetail/{id_lembur}','LemburController@tambahlemburdetail');

Route::post('prosestambahlemburdetail','LemburController@prosestambahlemburdetail');

Route::post('prosesubahlemburdetail','LemburController@prosesubahlemburdetail');

Route::get('cetaklembur/{id_lembur}','LemburController@cetaklembur');

Route::get('cetaklampiranlembur/{id_lembur}','LemburController@cetaklampiranlembur');

Route::get('hapuslembur/{id_lembur}','LemburController@hapuslembur');

Route::get('hapuslemburdetail/{id_lembur}/{id_lemburdetail}','LemburController@hapuslemburdetail');

Route::get('jsondatapegawai/{id_pegawai}','LemburController@jsondatapegawai');

Route::get('jsonlemburdetail/{id_lemburdetail}','LemburController@jsonlemburdetail');

Route::post('prosestambahjamlemburdetail', 'LemburController@prosestambahjamlemburdetail');

Route::get('daftarlemburpegawai', 'LemburController@tampildaftarlemburpegawai');
Route::post('daftarlemburpegawai', 'LemburController@pilihdaftarlemburpegawai');

Route::get('daftarlemburperbulan', 'LemburController@tampildaftarlemburperbulan');
Route::post('daftarlemburperbulan', 'LemburController@pilihdaftarlemburperbulan');


//Golongan
Route::get('golongan', 'GolonganBMNController@daftargolongan');
Route::get('tambahgolongan', 'GolonganBMNController@tambahgolongan');
Route::post('prosestambahgolongan', 'GolonganBMNController@prosestambahgolongan');
Route::get('ubahgolongan/{id_golongan}','GolonganBMNController@ubahgolongan');
Route::post('prosesubahgolongan','GolonganBMNController@prosesubahgolongan');
Route::get('hapusgolongan/{id_golongan}','GolonganBMNController@hapusgolongan');

//Bidang
Route::get('bidang', 'BidangBMNController@daftarbidang');
Route::get('tambahbidang', 'BidangBMNController@tambahbidang');
Route::post('prosestambahbidang', 'BidangBMNController@prosestambahbidang');
Route::get('ubahbidang/{id_bidang}','BidangBMNController@ubahbidang');
Route::post('prosesubahbidang','BidangBMNController@prosesubahbidang');
Route::get('hapusbidang/{id_bidang}','BidangBMNController@hapusbidang');
Route::get('jsondatagolongan/{id_golongan}','BidangBMNController@jsondatagolongan');

//Kelompok BMN
Route::get('kelompokbmn', 'KelompokBMNController@daftarkelompokbmn');
Route::get('tambahkelompokbmn', 'KelompokBMNController@tambahkelompokbmn');
Route::post('prosestambahkelompokbmn', 'KelompokBMNController@prosestambahkelompokbmn');
Route::get('ubahkelompokbmn/{id_kelompokbmn}','KelompokBMNController@ubahkelompokbmn');
Route::post('prosesubahkelompokbmn','KelompokBMNController@prosesubahkelompokbmn');
Route::get('hapuskelompokbmn/{id_kelompokbmn}','KelompokBMNController@hapuskelompokbmn');
Route::get('jsondatabidang/{id_bidang}','KelompokBMNController@jsondatabidang');

//Sub Kelompok BMN
Route::get('subkelompokbmn', 'SubkelompokBMNController@daftarsubkelompokbmn');
Route::get('tambahsubkelompokbmn', 'SubkelompokBMNController@tambahsubkelompokbmn');
Route::post('prosestambahsubkelompokbmn', 'SubkelompokBMNController@prosestambahsubkelompokbmn');
Route::get('ubahsubkelompokbmn/{id_subkelompokbmn}','SubkelompokBMNController@ubahsubkelompokbmn');
Route::post('prosesubahsubkelompokbmn','SubkelompokBMNController@prosesubahsubkelompokbmn');
Route::get('hapussubkelompokbmn/{id_subkelompokbmn}','SubkelompokBMNController@hapussubkelompokbmn');
Route::get('jsondatakelompok/{id_kelompok}','SubkelompokBMNController@jsondatakelompok');

//Sub Sub Kelompok BMN
Route::get('subsubkelompokbmn', 'SubsubkelompokBMNController@daftarsubsubkelompokbmn');
Route::get('tambahsubsubkelompokbmn', 'SubsubkelompokBMNController@tambahsubsubkelompokbmn');
Route::post('prosestambahsubsubkelompokbmn', 'SubsubkelompokBMNController@prosestambahsubsubkelompokbmn');
Route::get('ubahsubsubkelompokbmn/{id_subsubkelompokbmn}','SubsubkelompokBMNController@ubahsubsubkelompokbmn');
Route::post('prosesubahsubsubkelompokbmn','SubsubkelompokBMNController@prosesubahsubsubkelompokbmn');
Route::get('hapussubsubkelompokbmn/{id_subsubkelompokbmn}','SubsubkelompokBMNController@hapussubsubkelompokbmn');
Route::get('jsondatasubkelompok/{id_subkelompok}','SubsubkelompokBMNController@jsondatasubkelompok');

//BMN
Route::get('bmn', 'BMNController@daftarbmn');
Route::get('tambahbmn', 'BMNController@tambahbmn');
Route::post('prosestambahbmn', 'BMNController@prosestambahbmn');
Route::get('ubahbmn/{id_bmn}','BMNController@ubahbmn');
Route::post('prosesubahbmn','BMNController@prosesubahbmn');
Route::get('hapusbmn/{id_bmn}','BMNController@hapusbmn');
Route::get('qrcodebmn/{id_bmn}', 'BMNController@generateqrcode');
Route::get('detailbmn/{id_bmn}', 'BMNController@detailbmn');
Route::get('statistik', 'BMNController@statistik');
Route::get('daftarperbmn/{id_subsubkelompokbmn}', 'BMNController@daftarperbmn');

//Ruangan
Route::get('ruangan', 'RuanganController@daftarruangan');
Route::get('tambahruangan', 'RuanganController@tambahruangan');
Route::post('prosestambahruangan', 'RuanganController@prosestambahruangan');
Route::get('ubahruangan/{id_ruangan}','RuanganController@ubahruangan');
Route::post('prosesubahruangan','RuanganController@prosesubahruangan');
Route::get('hapusruangan/{id_ruangan}','RuanganController@hapusruangan');

//Peminjaman
Route::get('peminjaman', 'PeminjamanController@daftarpeminjaman');
Route::get('permohonanpeminjaman', 'PeminjamanController@permohonanpeminjaman');
Route::post('prosespermohonanpeminjaman', 'PeminjamanController@prosespermohonanpeminjaman');
Route::get('hapuspeminjaman/{id_peminjaman}','PeminjamanController@hapuspeminjaman');
Route::get('daftarapproval', 'PeminjamanController@daftarapproval');
Route::get('approvalpeminjaman/{id_peminjaman}', 'PeminjamanController@approvalpeminjaman');
Route::get('approvalpeminjaman/setujupeminjaman/{id_peminjaman}', 'PeminjamanController@setujupeminjaman');
Route::get('approvalpeminjaman/tolakpeminjaman/{id_peminjaman}', 'PeminjamanController@tolakpeminjaman');
Route::post('prosesvalidasipeminjaman', 'PeminjamanController@prosesvalidasipeminjaman');
Route::get('cetakformpeminjaman/{id_peminjaman}', 'PeminjamanController@cetakformpeminjaman');
