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
        if (auth()->user()->isAdmin()) {
            return redirect('admin/dashboard');
        } else {
            return redirect('user/calon-mahasiswa/formulir');
        }
    } else {
        return redirect('home');
    }
});
Route::get('home', 'LandingController@index');
Route::get('detail-jurusan/{id}', 'LandingController@detailJurusan');

Route::get('password', function() {
    return bcrypt('password');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('doRegister');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    Route::group(['prefix' => 'dashboard', 'middleware' => 'admin'], function() {
        Route::get('', 'DashboardController@index');
    });

    Route::group(['prefix' => 'setting', 'middleware' => 'admin'], function() {
        Route::get('profile', 'SettingController@profile');
        Route::post('profile/update', 'SettingController@profileUpdate');
    });

    Route::group(['prefix' => 'user', 'middleware' => 'admin'], function() {
        Route::get('index', 'UserController@index');
        Route::get('form/{type}/{id?}', 'UserController@form');
        Route::post('store', 'UserController@store');
        Route::post('update/{id}', 'UserController@update');
        Route::post('change-password/{id}', 'UserController@changePassword');
        Route::post('status/{id}', 'UserController@status');
        Route::delete('delete/{id}', 'UserController@delete');

        Route::group(['prefix' => 'group'], function() {
            Route::post('list', 'UserController@groupList');
        });
    });

    Route::group(['prefix' => 'gelombang', 'middleware' => 'admin'], function() {
        Route::get('index', 'GelombangController@index');
        Route::get('form/{type}/{id?}', 'GelombangController@form');
        Route::post('store', 'GelombangController@store');
        Route::post('update/{id}', 'GelombangController@update');
        Route::delete('delete/{id}', 'GelombangController@delete');
    });
    Route::group(['prefix' => 'kategori-jurusan', 'middleware' => 'admin'], function() {
        Route::get('index', 'KategoriJurusanController@index');
        Route::post('list', 'KategoriJurusanController@list');
        Route::get('form/{type}/{id?}', 'KategoriJurusanController@form');
        Route::post('store', 'KategoriJurusanController@store');
        Route::post('update/{id}', 'KategoriJurusanController@update');
        Route::delete('delete/{id}', 'KategoriJurusanController@delete');
    });
    Route::group(['prefix' => 'jurusan', 'middleware' => 'admin'], function() {
        Route::get('index', 'JurusanController@index');
        Route::get('form/{type}/{id?}', 'JurusanController@form');
        Route::post('store', 'JurusanController@store');
        Route::post('update/{id}', 'JurusanController@update');
        Route::delete('delete/{id}', 'JurusanController@delete');
    });
    Route::group(['prefix' => 'peminat', 'middleware' => 'admin'], function() {
        Route::get('index', 'PeminatController@index');
        Route::get('form/{type}/{id?}', 'PeminatController@form');
        Route::post('store', 'PeminatController@store');
        Route::post('update/{id}', 'PeminatController@update');
        Route::post('status/{id}', 'PeminatController@status');
        Route::delete('delete/{id}', 'PeminatController@delete');
    });

    Route::group(['prefix' => 'tagihan', 'middleware' => 'admin'], function() {
        Route::get('index', 'TagihanController@index');
        Route::post('status/{id}', 'TagihanController@status');
    });

    Route::group(['prefix' => 'calon-mahasiswa', 'middleware' => 'admin'], function() {
        Route::get('index', 'CalonMahasiswaController@index');
        Route::post('status-tes/{id}', 'CalonMahasiswaController@statusTes');
    });

    Route::group(['prefix' => 'datatable'], function() {
        Route::post('user', 'DatatableController@user');
        Route::post('gelombang', 'DatatableController@gelombang');
        Route::post('kategori-jurusan', 'DatatableController@kategoriJurusan');
        Route::post('jurusan', 'DatatableController@jurusan');
        Route::post('peminat', 'DatatableController@peminat');
        Route::post('calon-mahasiswa', 'DatatableController@calonMahasiswa');
        Route::post('tagihan', 'DatatableController@tagihan');
    });
});

Route::group(['prefix' => 'user'], function() {
    Route::post('list-jurusan', 'JurusanController@list');

    Route::get('calon-mahasiswa/formulir', 'CalonMahasiswaController@formulir');
    Route::post('calon-mahasiswa/upload-bukti-bayar', 'CalonMahasiswaController@uploadBuktiBayar');
    Route::post('calon-mahasiswa/pengisian-data', 'CalonMahasiswaController@pengisianData');
});

