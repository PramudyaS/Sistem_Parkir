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

Auth::routes();

Route::get('/','ControllerParkir@home');
Route::get('/home','ControllerParkir@home');
Route::get('/abort',function(){
	return view('404');
});

Route::get('/abort2',function(){
	return view('505');
});

Route::get('/qrcode', function () 
{
  return QRCode::phone('+62 83811991964')
  					->setSize(4)->setMargin(2)->png();    
});

Route::group(['prefix' => 'transaksi','middleware' =>['Kasir','auth']],function(){
	Route::get('/kendaraan_masuk','ControllerParkir@create');
	Route::get('/find_tarif','ControllerParkir@findTarif');
	Route::post('/StoreInput','ControllerParkir@store');
	Route::get('/DataParkiranMasuk','ControllerParkir@index');
	Route::get('/HapusDataParkiranMasuk/{id}','ControllerParkir@destroy');
	Route::get('/editDataParkiranMasuk/{id}','ControllerParkir@edit');
	Route::patch('/UpdateDataParkiranMasuk/{id}','ControllerParkir@update');
	Route::get('/search','ControllerParkir@search');

	Route::get('/struk/{id}','ControllerParkir@show');

	Route::get('/ParkirSelesai/{id}','ControllerParkir@selesai');
	Route::post('/StoreSelesai','ControllerParkir@storeSelesai');

	Route::get('/DataParkiranKeluar','ControllerParkir@showKeluar');

	Route::get('/searchKeluar','ControllerParkir@search2');
});

Route::group(['prefix' => 'laporan','middleware' => ['Manager','auth']],function(){
	Route::get('/LaporanParkiranKeluar','Laporan@index');
	Route::get('/LaporanParkiranTanggal','Laporan@show');
	Route::get('/result_tanggal','Laporan@process');
	Route::patch('/result_tanggal','Laporan@process');
});


Route::group(['prefix' => 'tarif','middleware' => ['Manager','auth']],function(){
	Route::get('/TarifParkir','ControllerTarif@index');
	Route::get('/HapusTarif/{id}','ControllerTarif@destroy');

	Route::post('/InputTarif','ControllerTarif@store');
	Route::get('/GetTarif/{id}','ControllerTarif@edit');
	Route::patch('/UpdateTarif/{id}','ControllerTarif@update');
});

Route::group(['prefix' => 'pegawai','middleware' => ['Manager','auth']],function(){
	Route::get('/DataPegawai','ControllerPegawai@index');
	Route::post('/InputPegawai','ControllerPegawai@create');
	Route::get('/HapusPegawai/{id}','ControllerPegawai@destroy');
	Route::get('/EditPegawai/{id}','ControllerPegawai@edit');
	Route::patch('/UpdatePegawai/{id}','ControllerPegawai@update');
});	

