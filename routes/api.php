<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Admin
Route::post('manager/login', 'API\ManagerController@login');
   
Route::prefix('admin')->middleware(['auth:apimanager','scope:admin'])->group( function () {
    Route::resource('seller_manager', 'API\SellerManagerController');
    Route::resource('product_manager', 'API\ProductManagerController');
});

// Seller
Route::prefix('seller')->middleware(['auth:apimanager','scope:seller'])->group( function () {
    Route::get('product', 'API\ProductManagerController@index');
    Route::get('product/{id}', 'API\ProductManagerController@show');
});

// Login Register User
Route::post('register', 'API\UserController@register');
Route::post('login', 'API\UserController@login');