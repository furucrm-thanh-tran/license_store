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

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', function (){
    return view('admin.index');
})->name('admin');

Route::get('/admin/sellermanager', function (){
    return view('admin.seller_manager');
})->name('admin.sellermanager');

Route::get('/admin/transactionmanager', function (){
    return view('admin.transaction_manager');
})->name('admin.transactionmanager');

Route::get('/admin/productmanager', function (){
    return view('admin.product_manager');
})->name('admin.productmanager');

Route::get('/admin/license-key', function (){
    return view('admin.license-key');
})->name('admin.license-key');

