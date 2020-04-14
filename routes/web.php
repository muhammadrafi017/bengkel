<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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

Route::get('', function() {
    if (auth()->user()) {
        return redirect('dashboard');
    } else {
        return redirect('login');
    }
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('nota/tracking', 'NotaController@tracking');
Route::post('nota/tracking', 'NotaController@trackingProcess');

Route::group(['middleware' => 'auth'], function() {

    Route::group(['middleware' => 'actor:owner,admin,member'], function() {
        Route::post('kupon/list', 'KuponController@list');
        Route::post('produk/list', 'ProdukController@list');
        Route::post('service/list', 'ServiceController@list');
        Route::post('mekanik/list', 'MekanikController@list');
    });

    Route::group(['prefix' => 'dashboard', 'middleware' => 'actor:owner,admin'], function() {
        Route::get('', 'DashboardController@index');
    });

    Route::group(['prefix' => 'user', 'middleware' => 'actor:owner,admin,member'], function() {
        Route::get('', 'UserController@index');
        Route::post('change-password/{id}', 'UserController@changePassword');
        Route::post('find-member', 'UserController@findMember');
    });

    Route::group(['prefix' => 'kupon', 'middleware' => 'actor:owner'], function() {
        Route::get('', 'KuponController@index');
        Route::get('form/{type}/{id?}', 'KuponController@form');
        Route::post('store', 'KuponController@store');
        Route::post('update/{id}', 'KuponController@update');
        Route::delete('delete/{id}', 'KuponController@delete');
    });

    Route::group(['prefix' => 'produk', 'middleware' => 'actor:owner'], function() {
        Route::get('', 'ProdukController@index');
        Route::get('form/{type}/{id?}', 'ProdukController@form');
        Route::post('store', 'ProdukController@store');
        Route::post('update/{id}', 'ProdukController@update');
        Route::delete('delete/{id}', 'ProdukController@delete');
    });

    Route::group(['prefix' => 'mekanik', 'middleware' => 'actor:owner'], function() {
        Route::get('', 'MekanikController@index');
        Route::get('form/{type}/{id?}', 'MekanikController@form');
        Route::post('store', 'MekanikController@store');
        Route::post('update/{id}', 'MekanikController@update');
        Route::delete('delete/{id}', 'MekanikController@delete');
    });

    Route::group(['prefix' => 'service', 'middleware' => 'actor:owner'], function() {
        Route::get('', 'ServiceController@index');
        Route::get('form/{type}/{id?}', 'ServiceController@form');
        Route::post('store', 'ServiceController@store');
        Route::post('update/{id}', 'ServiceController@update');
        Route::delete('delete/{id}', 'ServiceController@delete');
    });

    Route::group(['prefix' => 'service-barang', 'middleware' => 'actor:owner,admin'], function() {
        Route::get('', 'ServiceBarangController@index');
        Route::get('order', 'ServiceBarangController@order');
        Route::get('form/create', 'ServiceBarangController@form');
        Route::post('list', 'ServiceBarangController@list');
        Route::post('store', 'ServiceBarangController@store');
        Route::post('store-order', 'ServiceBarangController@storeOrder');
        Route::post('status/{id?}', 'ServiceBarangController@updateStatus');
        Route::post('progres', 'ServiceBarangController@updateProgres');
        Route::get('report/execution/{start_date}/{end_date}', 'ServiceBarangController@reportExecution');
        Route::get('report/cumulative/{start_date}/{end_date}', 'ServiceBarangController@reportCumulative');

        Route::group(['prefix' => 'nota'], function() {
            Route::post('list', 'ServiceBarangController@listNotaService');
        });
        Route::group(['prefix' => 'barang'], function() {
            Route::post('list-by-nota', 'ServiceBarangController@listBarangByNota');
        });
    });

    Route::group(['prefix' => 'produk-transaksi', 'middleware' => 'actor:owner,admin'], function() {
        Route::get('offline', 'ProdukTransaksiController@offline');
    });

    Route::group(['prefix' => 'nota'], function() {
        Route::group(['prefix' => 'service'], function() {
            Route::get('', 'NotaServiceController@index');
            Route::post('payment/{id}', 'NotaServiceController@updatePayment');
            Route::post('taking/{id}', 'NotaServiceController@updateTaking');
            Route::get('print/{id}', 'NotaServiceController@print');
            Route::get('report/earning/{start_date}/{end_date}', 'NotaServiceController@reportEarning');
        });
    });

    

    Route::group(['prefix' => 'datatable'], function() {
        Route::post('user', 'DatatableController@user');
        Route::post('kupon', 'DatatableController@kupon');
        Route::post('produk', 'DatatableController@produk');
        Route::post('produk-transaksi', 'DatatableController@produkTransaksi');
        Route::post('mekanik', 'DatatableController@mekanik');
        Route::post('service', 'DatatableController@service');
        Route::post('service-barang', 'DatatableController@serviceBarang');
        Route::post('nota-service', 'DatatableController@notaService');
    });
});

