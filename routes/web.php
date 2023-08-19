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

Route::get('/', 'WebController@index');
Route::get('pilih-satuan-pendidikan', 'WebController@pilihSatuanPendidikan');
Route::get('buat-permohonan/{pendidikan}', 'WebController@buatPermohonan');
Route::post('save-buat-permohonan/{pendidikan}', 'WebController@saveBuatPermohonan');
Route::get('permohonan/{noPendaftaran}', 'WebController@permohonan');
Route::get('cek-permohonan', 'WebController@cekPermohonan');
Route::get('tentang', 'WebController@tentang');

Auth::routes();
Route::get('login', 'LoginController@index')->middleware('guest');
Route::post('login', 'LoginController@login')->middleware('guest')->name('login');
Route::get('register', 'LoginController@register')->middleware('guest');
Route::post('register', 'LoginController@saveRegister')->middleware('guest')->name('register');
Route::get('logout', 'LoginController@logout');

Route::group([ 'middleware' => 'auth' ], function() {

	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('import-templates/{filename}', 'DashboardController@templateImport')->name('import_templates');

	// Banner Slide
	Route::prefix('banner-slide')->group(function(){
		Route::get('/', 'BannerSlideController@index')->name('banner_slide');
		Route::post('store', 'BannerSlideController@store')->name('banner_slide.store');
		Route::put('{bannerSlide}/update', 'BannerSlideController@update')->name('banner_slide.update');
		Route::get('{bannerSlide}/get', 'BannerSlideController@get')->name('banner_slide.get');
		Route::delete('{bannerSlide}/destroy', 'BannerSlideController@destroy')->name('banner_slide.destroy');
	});

	// Anggota
	Route::prefix('anggota')->group(function(){
		Route::get('/', 'AnggotaController@index')->name('anggota');
		Route::post('store', 'AnggotaController@store')->name('anggota.store');
		Route::post('import', 'AnggotaController@import')->name('anggota.import');
		Route::put('{anggota}/update', 'AnggotaController@update')->name('anggota.update');
		Route::get('{anggota}/get', 'AnggotaController@get')->name('anggota.get');
		Route::delete('{anggota}/destroy', 'AnggotaController@destroy')->name('anggota.destroy');
	});

	// Korlap
	Route::prefix('korlap')->group(function(){
		Route::get('/', 'KorlapController@index')->name('korlap');
		Route::post('store', 'KorlapController@store')->name('korlap.store');
		Route::put('{korlap}/update', 'KorlapController@update')->name('korlap.update');
		Route::get('{korlap}/get', 'KorlapController@get')->name('korlap.get');
		Route::delete('{korlap}/destroy', 'KorlapController@destroy')->name('korlap.destroy');
	});

	// Kategori Pengeluaran
	Route::prefix('kategori-pengeluaran')->group(function(){
		Route::get('/', 'KategoriPengeluaranController@index')->name('kategori_pengeluaran');
		Route::post('store', 'KategoriPengeluaranController@store')->name('kategori_pengeluaran.store');
		Route::put('{kategoriPengeluaran}/update', 'KategoriPengeluaranController@update')->name('kategori_pengeluaran.update');
		Route::get('{kategoriPengeluaran}/get', 'KategoriPengeluaranController@get')->name('kategori_pengeluaran.get');
		Route::delete('{kategoriPengeluaran}/destroy', 'KategoriPengeluaranController@destroy')->name('kategori_pengeluaran.destroy');
	});

	// Kategori Pendidikan
	Route::prefix('kategori-pendidikan')->group(function () {
		Route::get('/', 'KategoriPendidikanController@index')->name('kategori_pendidikan');
		Route::get('create', 'KategoriPendidikanController@create')->name('kategori_pendidikan.create');
		Route::post('store', 'KategoriPendidikanController@store')->name('kategori_pendidikan.store');
		Route::get('{kategoriPendidikan}/detail', 'KategoriPendidikanController@detail')->name('kategori_pendidikan.detail');
		Route::get('{kategoriPendidikan}/edit', 'KategoriPendidikanController@edit')->name('kategori_pendidikan.edit');
		Route::put('{kategoriPendidikan}/update', 'KategoriPendidikanController@update')->name('kategori_pendidikan.update');
		Route::delete('{kategoriPendidikan}/destroy', 'KategoriPendidikanController@destroy')->name('kategori_pendidikan.destroy');
	});

	// Pendidikan
	Route::prefix('pendidikan')->group(function () {
		Route::get('/', 'PendidikanController@index')->name('pendidikan');
		Route::get('create', 'PendidikanController@create')->name('pendidikan.create');
		Route::post('store', 'PendidikanController@store')->name('pendidikan.store');
		Route::get('{pendidikan}/detail', 'PendidikanController@detail')->name('pendidikan.detail');
		Route::get('{pendidikan}/edit', 'PendidikanController@edit')->name('pendidikan.edit');
		Route::put('{pendidikan}/update', 'PendidikanController@update')->name('pendidikan.update');
		Route::delete('{pendidikan}/destroy', 'PendidikanController@destroy')->name('pendidikan.destroy');
	});

	// Persyaratan
	Route::prefix('persyaratan')->group(function () {
		Route::get('/', 'PersyaratanController@index')->name('persyaratan');
		Route::get('create', 'PersyaratanController@create')->name('persyaratan.create');
		Route::post('store', 'PersyaratanController@store')->name('persyaratan.store');
		Route::get('{persyaratan}/detail', 'PersyaratanController@detail')->name('persyaratan.detail');
		Route::get('{persyaratan}/edit', 'PersyaratanController@edit')->name('persyaratan.edit');
		Route::put('{persyaratan}/update', 'PersyaratanController@update')->name('persyaratan.update');
		Route::delete('{persyaratan}/destroy', 'PersyaratanController@destroy')->name('persyaratan.destroy');
	});


	// Permohonan
	Route::prefix('permohonan')->group(function () {
		Route::get('/', 'PermohonanController@index')->name('permohonan');
		Route::get('{permohonan}/detail', 'PermohonanController@detail')->name('permohonan.detail');
		Route::get('{permohonan}/konfirmasi-permohonan', 'PermohonanController@konfirmasiPermohonan')->name('permohonan.konfirmasi_permohonan');
		Route::post('{permohonan}/simpan-konfirmasi-permohonan', 'PermohonanController@simpanKonfirmasiPermohonan')->name('permohonan.simpan_konfirmasi_permohonan');
	});


	// User
	Route::prefix('user')->group(function () {
		Route::get('/', 'UserController@index')->name('user');
		Route::get('create', 'UserController@create')->name('user.create');
		Route::post('store', 'UserController@store')->name('user.store');
		Route::get('{admin}/edit', 'UserController@edit')->name('user.edit');
		Route::put('{admin}/update', 'UserController@update')->name('user.update');
		Route::delete('{admin}/destroy', 'UserController@destroy')->name('user.destroy');
	});

	// Permohonan Perizinan
	Route::prefix('permohonan-perizinan')->group(function () {
		Route::get('/', 'PermohonanPerizinanController@index')->name('permohonan_perizinan');
		Route::get('create', 'PermohonanPerizinanController@create')->name('permohonan_perizinan.create');
		Route::post('store', 'PermohonanPerizinanController@store')->name('permohonan_perizinan.store');
		Route::get('{permohonan}/detail', 'PermohonanPerizinanController@detail')->name('permohonan_perizinan.detail');
	});




	Route::prefix('setting')->group(function () {
		Route::prefix('change-password')->group(function () {
			Route::get('/', 'SettingController@changePasswordIndex')->name('setting.change_password');
			Route::post('save', 'SettingController@changePasswordSave')->name('setting.change_password.save');
		});
	});



	Route::prefix('profile')->group(function () {
		Route::get('/', 'UserController@profileIndex')->name('profile');

		Route::get('edit', 'UserController@profileEdit')->name('profile.edit');
		Route::post('edit', 'UserController@profileUpdate')->name('profile.update');
	});

});


Route::get('migrate', function(){
	\App\Models\IuranWarga::setAllNamaBulanIuran();
	\Artisan::call('migrate');
	\Artisan::call('view:clear');
	\Artisan::call('cache:clear');
	\Artisan::call('route:clear');
	\Artisan::call('config:clear');
});