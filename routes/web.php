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

Route::get('/home', 'HomeController@index')->name('home');

// Manager routes
Route::prefix('manager')->group(function () {
    // Route::get('/', 'ManagerController@index')->name('seller.dashboard');
    Route::get('/login', 'Auth\ManagerLoginController@showLoginForm')->name('manager.login');
    Route::post('/login', 'Auth\ManagerLoginController@login')->name('manager.login.submit');
});

Route::prefix('admin')->group(function () {
    Route::get('/', 'ManagerController@adminHome')->name('admin')->middleware('role');
    // Route::get('/sellermanager', 'AdminController@sellerManager')->name('admin.sellermanager')->middleware('role');
    Route::resource('/seller_manager','SellerManagerController')->middleware('role');
    // Route::get('seller_manager/{id}/edit/','SellerManagerController@edit')->middleware('role');
    // Route::post('seller_manager/{id}/update','SellerManagerController@update')->middleware('role');

    Route::get('/transactionmanager', 'AdminController@transactionManager')->name('admin.transactionmanager')->middleware('role');
    Route::get('/productmanager', 'AdminController@productManager')->name('admin.productmanager')->middleware('role');
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



// Route::get('admin', function (){
//     return view('admin.index');
// })->name('admin');

// Route::get('/admin/sellermanager', function (){
//     return view('admin.seller_manager');
// })->name('admin.sellermanager');

// Route::get('/admin/transactionmanager', function (){
//     return view('admin.transaction_manager');
// })->name('admin.transactionmanager');

// Route::get('/admin/productmanager', function (){
//     return view('admin.product_manager');
// })->name('admin.productmanager');

// Route::get('/admin/license-key', function (){
//     return view('admin.license-key');
// })->name('admin.license-key');
