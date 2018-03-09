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

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function(){
    Route::get('/', 'AdminController@index')->name('admin');

    Route::get('/balance', 'BalanceController@index')->name('balance');

    Route::get('/balance/deposit', 'BalanceController@deposit')->name('balance.deposit');
    Route::post('/balance/deposit', 'BalanceController@depositStore')->name('deposit.store');

    Route::get('/balance/draw', 'BalanceController@withdraw')->name('balance.withdraw');
    Route::post('/balance/draw', 'BalanceController@withdrawStore')->name('withdraw.store');

    Route::get('/balance/transfer/step-1', 'BalanceController@transfer')->name('balance.transfer');
    Route::get('/balance/transfer/confirm', 'BalanceController@transferConfirm')->name('transfer.confirm');
    Route::post('/balance/transfer/', 'BalanceController@transferStore')->name('transfer.store');

    Route::get('/historic/', 'BalanceController@historic')->name('historic');

    Route::match(['get', 'post'], '/historic/search', 'BalanceController@historicSearch')->name('historic.search');//
});

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function (){
    Route::get('profile', 'UserController@profile')->name('profile');

    Route::post('profile/update', 'UserController@profileUpdate')->name('profile.update');
});


Route::get('/', 'SiteController@index');

Auth::routes();
