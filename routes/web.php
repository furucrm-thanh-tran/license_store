<?php

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

Route::get('/', function () {
    return view('index');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

// Customer routes
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile');

// Manager routes
Route::prefix('manager')->group(function () {
    // Route::get('/', 'ManagerController@index')->name('seller.dashboard');
    Route::get('/login', 'Auth\ManagerLoginController@showLoginForm')->name('manager.login');
    Route::post('/login', 'Auth\ManagerLoginController@login')->name('manager.login.submit');
});

Route::prefix('admin')->group(function () {
    Route::get('/', 'ManagerController@adminHome')->name('admin')->middleware('role');
    Route::resource('/seller_manager','SellerManagerController')->middleware('role');
    Route::resource('/seller_manager', 'SellerManagerController')->middleware('role');
    Route::resource('/product_manager', 'ProductManagerController')->middleware('role');
    Route::get('product_manager/fetch_icon/{id}', 'ProductManagerController@fetch_icon');
    Route::get('/transactionmanager', 'AdminController@transactionManager')->name('admin.transactionmanager')->middleware('role');
    Route::get('/license-key', 'ManagerController@licenseKey')->name('admin.license-key');
    Route::get('/bill/detail', 'ManagerController@billDetail')->name('admin.bill-detail');
});

Route::prefix('seller')->group(function () {
    Route::get('/', 'ManagerController@index')->name('seller');
    Route::get('/customermanager', 'SellerController@customerManager')->name('seller.customermanager');
    Route::get('/productmanager', 'SellerController@productManager')->name('seller.productmanager');
    Route::get('/transactionmanager', 'SellerController@transactionManager')->name('seller.transactionmanager');
    Route::get('/profile', 'SellerController@profile')->name('seller.profile');
    Route::get('/bill', 'SellerController@bill')->name('seller.bill');
    Route::get('/bill/detail', 'ManagerController@billDetail')->name('seller.bill-detail');
    Route::get('/license-key', 'ManagerController@licenseKey')->name('seller.license-key');
});
