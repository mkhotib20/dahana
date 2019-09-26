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

Route::get('/', function(){
    return redirect('/login');
});
Route::get('/login', 'User@login');
Route::get('/developer/log', 'LogController@index');

Route::post('perjalanan/updateBiaya', 'PerjalananController@updateBiaya')->middleware('cek_role:1,0,2');
Route::get('perjalanan/editBiaya/{id}', 'PerjalananController@editBiaya')->middleware('cek_role:1,0,2');
Route::resource('driver', 'DriverController')->middleware('cek_role:1,0');
Route::resource('karyawan', 'KaryawanController')->middleware('cek_role:1,0');
Route::resource('bbm', 'BbmController')->middleware('cek_role:1,0');
Route::resource('kendaraan', 'KendaraanController')->middleware('cek_role:1,0');
Route::resource('kategori', 'KategoriController')->middleware('cek_role:1,0');
Route::get('tujuan/getJarak/{kota}', 'TujuanController@getJarak')->middleware('cek_role:1,0,2');
Route::resource('tujuan', 'TujuanController')->middleware('cek_role:1,0');
Route::get('perjalanan/sendEmail', 'PerjalananController@sendEmail')->middleware('cek_role:1,0,2');
Route::post('perjalanan/selesai', 'PerjalananController@selesai')->middleware('cek_role:1,0,2');
Route::get('perjalanan/tambah', 'PerjalananController@tambah')->middleware('cek_role:1,0', 'cek_biaya');
Route::get('perjalanan/json', 'PerjalananController@json')->middleware('cek_role:1,0,2');
Route::get('json_saldo', 'DashboardController@json_saldo')->middleware('cek_role:1,0,2');
Route::get('perjalanan/json_jarak', 'PerjalananController@json_jarak')->middleware('cek_role:1,0,2');
Route::get('perjalanan/json_bbm', 'PerjalananController@json_bbm')->middleware('cek_role:1,0,2');
Route::get('dashboard/json_biaya', 'DashboardController@json_biaya')->middleware('cek_role:1,0,2');

Route::resource('perjalanan', 'PerjalananController')->middleware('cek_role:1,0,2');
Route::post('topup', 'LimitController@topup')->middleware('cek_role:1,0');
Route::get('deltrans/{id}', 'LimitController@deltrans')->middleware('cek_role:1,0');
Route::post('saku', 'DriverController@saku')->middleware('cek_role:1,0');
Route::get('saku_json', 'DriverController@saku_json')->middleware('cek_role:1,0');

Route::resource('unit-kerja', 'UnitKerjaController')->middleware('cek_role:1,0');
Route::get('perjalanan/invoice/{id}', 'InvoiceController@index')->middleware('cek_role:1,0,2');
Route::get('perjalanan/selesai/{id}', 'InvoiceController@selesai')->middleware('cek_role:1,0,2');
Route::get('perjalanan/adjusment/{id}', 'InvoiceController@adjusment')->middleware('cek_role:1,0,2');
Route::post('perjalanan/cetak-rekap/', 'InvoiceController@rekap')->middleware('cek_role:1,0,2');

Route::get('/dashboard', 'DashboardController@index')->middleware('cek_role:1,0,2');
Route::resource('limit', 'LimitController')->middleware('cek_role:1,0');
Route::post('ttd/saveEmail', 'TtdController@saveEmail')->middleware('cek_role:1,0');
Route::resource('ttd', 'TtdController')->middleware('cek_role:1,0');

Route::resource('manajemen-user', 'UserMgmt')->middleware('cek_role:0');
Auth::routes();

