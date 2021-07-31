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

Route::bind('id', function ( $id ) {
	$decoded = \Hashids::decode($id);
	return count($decoded) > 0 ? $decoded[0] : false;
});


Route::get('/storage-link', function() {
	$exitCode = Artisan::call('storage:link');
});

Route::get('/migrate-refresh', function(){
    $exit = Artisan::call('migrate:refresh',['--seed' => ' ']);
    return 'ok';
});

Route::get('/wipe', function(){
    $exit = Artisan::call('db:wipe');
    return 'ok';
});

Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:clear');
    
    return 'cleared!';
});

Route::get('/404', function(){
	return view('pages.404');
})->name('404');

Route::get('/500', function(){
	return view('pages.500');
})->name('500');

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/login/proses', 'Auth\LoginController@login')->name('login.proses');

Route::group(['middleware' => ['auth.admin']], function () {
	/*
	|--------------------------------------------------------------------------
	| Dashboard Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('/get-pesanan-baru', 'Admin\PesananController@getPesananBaru')->name('admin.get-pesanan-baru');
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('/call', 'Admin\UserController@call')->name('call');


	/*
	|--------------------------------------------------------------------------
	| Pengguna Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::group(['prefix' => 'admin'], function () {
		/*
		|--------------------------------------------------------------------------
		| Pengguna Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::get('pengguna', 'Admin\UserController@index')->name('user.index');
		Route::get('pengguna/create', 'Admin\UserController@create')->name('user.create');
		Route::post('pengguna/store', 'Admin\UserController@store')->name('user.store');
		Route::get('pengguna/{id}/edit', 'Admin\UserController@edit')->name('user.edit');
		Route::put('pengguna/{id}/edit', 'Admin\UserController@update')->name('user.update');
		Route::put('pengguna/validasi/{id}', 'Admin\UserController@validasi')->name('user.validasi');
		Route::patch('pengguna/delete/{id}', 'Admin\UserController@delete')->name('user.delete');
		Route::delete('pengguna/delete/{id}', 'Admin\UserController@destroy')->name('user.destroy');
		Route::post('pengguna/restore/{id}', 'Admin\UserController@restore')->name('user.restore');

		/*
		|--------------------------------------------------------------------------
		| Order Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::get('order', 'Admin\OrderController@index')->name('order.index');
		Route::get('order/create', 'Admin\OrderController@create')->name('order.create');
		Route::get('order/{id}/upload', 'Admin\OrderController@formUpload')->name('order.form.upload');
		Route::put('order/{id}/upload', 'Admin\OrderController@upload')->name('order.upload');
		Route::get('order/{id}/proses', 'Admin\OrderController@proses')->name('order.proses');
		Route::patch('order/delete', 'Admin\OrderController@delete')->name('order.delete');
		Route::patch('order/retur', 'Admin\OrderController@retur')->name('order.retur');
		Route::post('order/store', 'Admin\OrderController@store')->name('order.store');
		Route::delete('order/delete/{id}', 'Admin\OrderController@destroy')->name('order.destroy');
		Route::post('order/restore/{id}', 'Admin\OrderController@restore')->name('order.restore');

		/*
		|--------------------------------------------------------------------------
		| Stok Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::post('stok/update', 'Admin\OrderController@updateStok')->name('stok.update');

		/*
		|--------------------------------------------------------------------------
		| Pengaturan Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::get('pengaturan', 'Admin\PengaturanController@index')->name('pengaturan.index');
		Route::put('pengaturan/{id}/update', 'Admin\PengaturanController@update')->name('pengaturan.update');

		/*
		|--------------------------------------------------------------------------
		| Profile Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::get('profile', 'Admin\ProfileController@index')->name('profile.index');
		Route::put('profile/{id}/update', 'Admin\ProfileController@update')->name('profile.update');

		/*
		|--------------------------------------------------------------------------
		| Produk Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::get('produk', 'Admin\ProdukController@index')->name('produk.index');
		Route::get('produk/create', 'Admin\ProdukController@create')->name('produk.create');
		Route::post('produk/store', 'Admin\ProdukController@store')->name('produk.store');
		Route::get('produk/{id}/edit', 'Admin\ProdukController@edit')->name('produk.edit');
		Route::put('produk/{id}/edit', 'Admin\ProdukController@update')->name('produk.update');
		Route::patch('produk/delete/{id}', 'Admin\ProdukController@delete')->name('produk.delete');
		Route::delete('produk/delete/{id}', 'Admin\ProdukController@destroy')->name('produk.destroy');
		Route::post('produk/restore/{id}', 'Admin\ProdukController@restore')->name('produk.restore');

		/*
		|--------------------------------------------------------------------------
		| Pesanan Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::get('pesanan-produk', 'Admin\PesananController@index')->name('pesanan_produk.index');
		Route::get('pesanan-produk/{id}/proses', 'Admin\PesananController@proses')->name('pesanan_produk.proses');
		Route::get('pesanan-produk/{id}/proses-retur', 'Admin\PesananController@prosesRetur')->name('pesanan_produk.proses_retur');
		Route::patch('pesanan-produk/delete', 'Admin\PesananController@delete')->name('pesanan_produk.delete');
		Route::delete('pesanan-produk/delete/{id}', 'Admin\PesananController@destroy')->name('pesanan_produk.destroy');
		Route::post('pesanan-produk/restore/{id}', 'Admin\PesananController@restore')->name('pesanan_produk.restore');

		Route::get('laporan-transaksi-bahan-baku', 'Admin\LaporanTransaksiBahanBakuController@index')->name('admin.laporan.transaksi.bahan.index');
		Route::post('laporan-transaksi-bahan-baku/cetak', 'Admin\LaporanTransaksiBahanBakuController@cetakExcel')->name('admin.laporan.transaksi.bahan.cetak');

		Route::get('laporan-transaksi-produk-jadi', 'Admin\LaporanTransaksiProdukJadiController@index')->name('admin.laporan.transaksi.produk_jadi.index');
		Route::post('laporan-transaksi-produk-jadi/cetak', 'Admin\LaporanTransaksiProdukJadiController@cetakExcel')->name('admin.laporan.transaksi.produk_jadi.cetak');
	});

});


Route::get('/daftar', 'Auth\LoginController@daftarView')->name('daftar');
Route::post('/daftar/proses', 'Auth\LoginController@daftar')->name('daftar.proses');

Route::group(['middleware' => ['auth.user']], function () {
	/*
	|--------------------------------------------------------------------------
	| Dashboard Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('/chatting', 'Supplier\ChattingController@index')->name('chatting');


	/*
	|--------------------------------------------------------------------------
	| Profile Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('supplier/profile', 'Supplier\ProfileController@index')->name('supplier.profile.index');
	Route::put('supplier/profile/{id}/update', 'Supplier\ProfileController@update')->name('supplier.profile.update');

	Route::get('supplier/get-pesanan-baru', 'Supplier\PesananController@getPesananBaru')->name('supplier.get-pesanan-baru');
	/*
	|--------------------------------------------------------------------------
	| Supplier Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::group(['middleware' => ['auth.isValid'], 'prefix' => 'supplier'], function () {

		/*
		|--------------------------------------------------------------------------
		| Bahan Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::get('/bahan', 'Supplier\BahanController@index')->name('supplier.bahan.index');
		Route::get('bahan/create', 'Supplier\BahanController@create')->name('supplier.bahan.create');
		Route::post('bahan/store', 'Supplier\BahanController@store')->name('supplier.bahan.store');
		Route::get('bahan/{id}/edit', 'Supplier\BahanController@edit')->name('supplier.bahan.edit');
		Route::put('bahan/{id}/edit', 'Supplier\BahanController@update')->name('supplier.bahan.update');
		Route::patch('bahan/delete/{id}', 'Supplier\BahanController@delete')->name('supplier.bahan.delete');
		Route::delete('bahan/delete/{id}', 'Supplier\BahanController@destroy')->name('supplier.bahan.destroy');
		Route::post('bahan/restore/{id}', 'Supplier\BahanController@restore')->name('supplier.bahan.restore');

		/*
		|--------------------------------------------------------------------------
		| Pesanan Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::get('/pesanan', 'Supplier\PesananController@index')->name('supplier.pesanan.index');
		Route::get('pesanan/{id}/proses', 'Supplier\PesananController@proses')->name('supplier.pesanan.proses');
		Route::get('pesanan/{id}/proses-retur', 'Supplier\PesananController@prosesRetur')->name('supplier.pesanan.proses_retur');
		Route::patch('pesanan/delete', 'Supplier\PesananController@delete')->name('supplier.pesanan.delete');
		Route::delete('pesanan/delete/{id}', 'Supplier\PesananController@destroy')->name('supplier.pesanan.destroy');
		Route::post('pesanan/restore/{id}', 'Supplier\PesananController@restore')->name('supplier.pesanan.restore');
		Route::get('pesanan/{id}/upload', 'Supplier\PesananController@formUpload')->name('supplier.pesanan.form.upload');
		Route::put('pesanan/{id}/upload', 'Supplier\PesananController@upload')->name('supplier.pesanan.upload');
	});

	/*
	|--------------------------------------------------------------------------
	| Profile Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('distributor/profile', 'Distributor\ProfileController@index')->name('distributor.profile.index');
	Route::put('distributor/profile/{id}/update', 'Distributor\ProfileController@update')->name('distributor.profile.update');

	/*
	|--------------------------------------------------------------------------
	| Distributor Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::group(['middleware' => ['auth.isValid'], 'prefix' => 'distributor'], function () {

		/*
		|--------------------------------------------------------------------------
		| Order Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::get('order', 'Distributor\OrderController@index')->name('distributor.order.index');
		Route::get('order/create', 'Distributor\OrderController@create')->name('distributor.order.create');
		Route::get('order/{id}/upload', 'Distributor\OrderController@formUpload')->name('distributor.order.form.upload');
		Route::put('order/{id}/upload', 'Distributor\OrderController@upload')->name('distributor.order.upload');
		Route::get('order/{id}/proses', 'Distributor\OrderController@proses')->name('distributor.order.proses');
		Route::patch('order/retur', 'Distributor\OrderController@retur')->name('distributor.order.retur');
		Route::patch('order/delete', 'Distributor\OrderController@delete')->name('distributor.order.delete');
		Route::post('order/store', 'Distributor\OrderController@store')->name('distributor.order.store');
		Route::delete('order/delete/{id}', 'Distributor\OrderController@destroy')->name('distributor.order.destroy');
		Route::post('order/restore/{id}', 'Distributor\OrderController@restore')->name('distributor.order.restore');

		Route::get('laporan-transaksi-order', 'Distributor\LaporanTransaksiOrderController@index')->name('distributor.laporan.transaksi.index');
		Route::post('laporan-transaksi-order/cetak', 'Distributor\LaporanTransaksiOrderController@cetakExcel')->name('distributor.laporan.transaksi.cetak');
	});


});