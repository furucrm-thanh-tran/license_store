<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', 'CustomerController@index');
Route::get('fetch_icon/{id}', 'CustomerController@fetch_icon');

// Route::get('/welcome', function () {
//     return view('welcome');
// });

Auth::routes();

// Customer routes}}}}}}}}}}}}}}}}}}}}}}}
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home_new', 'CustomerController@index_new');
Route::get('/home_update', 'CustomerController@index_update');
Route::get('/home_view', 'CustomerController@index_view');
Route::get('/home_buy', 'CustomerController@index_buy');
Route::get('/insert_view', 'CustomerController@insert_view');
// profile
Route::get('/profile', 'HomeController@profile')->name('profile');

Route::get('/frm_insertcard', 'HomeController@frm_insertcard')->name('frm_insertcard');
Route::get('/insertcard/{id}', 'HomeController@insertcard')->name('insertcard');
Route::get('card/{id}', 'HomeController@paymentprofile_delete')->name('del_card_item');
Route::post('card/edit', 'HomeController@paymentprofile_edit')->name('edit_card_item');

// cart
Route::get('shoppingcart', 'HomeController@shopping_cart')->name('cart');
Route::get('cart/delete', 'HomeController@del_cart_item')->name('del_cart_item');
Route::put('cart/update', 'HomeController@upd_cart_item')->name('upd_cart_item');
Route::post('cart/add', 'CustomerController@add_cart_item')->name('add_cart_item');
Route::get('info_cus/{id}', 'CustomerController@edit_info_cus')->name('edit_info_cus');
Route::post('create_bill', 'HomeController@create_bill')->name('create_bill');
/// Bill
Route::get('list_bills/{id}', 'HomeController@list_bills')->name('list_bills');
Route::get('bill_detail/{id}', 'HomeController@bill_detail')->name('bill_detail');
// Route::get('bill_detail/{id}','HomeController@bill_detail')->name('bill_detail');
Route::post('list_bills/feedback/add','HomeController@feedback_add');
Route::get('feedback_index','HomeController@feedback_index');

// End customer route}}}}}}}}}}}}}}}}}}}}

// Manager routes
Route::prefix('manager')->group(function () {
    Route::get('/login', 'Auth\ManagerLoginController@showLoginForm')->name('manager.login');
    Route::post('/login', 'Auth\ManagerLoginController@login')->name('manager.login.submit');
});

// Admin routes
Route::prefix('admin')->middleware('is_admin')->group(function () {
    Route::get('/', 'ManagerController@adminHome')->name('admin');

    Route::resource('/seller_manager', 'SellerManagerController');

    Route::resource('/product_manager', 'ProductManagerController');

    Route::get('/profile', 'AdminController@showProfile')->name('admin.profile');

    Route::get('/transactionmanager', 'AdminController@transactionManager')->name('admin.transactionmanager');

    Route::get('/bill/detail/{id}', 'ManagerController@billDetail')->name('admin.bill-detail');
    Route::post('/transactionmanager/{id}', 'AdminController@updateTransaction');
    Route::resource('/transaction', 'TransactionController');
});

//Licenses
Route::resource('/license', 'LicenseController');
Route::get('/get_bill', 'LicenseController@get_bill');
Route::get('/create_key', 'LicenseController@create_key');

Route::get('/hello/newadmin/register', 'RegisterAdminController@showAdminRegister')->name('newadmin.register');
Route::post('/hello/newadmin/register', 'RegisterAdminController@createAdmin')->name('newadmin.register.submit');
// Route::post('/hello/newadmin/login', 'RegisterAdminController@checkLogin')->name('newadmin.login.submit');


// Seller routes
Route::prefix('seller')->middleware('is_seller')->group(function () {
    Route::get('/', 'ManagerController@index')->name('seller');

    Route::resource('/productmanager', 'ProductController');

    Route::get('/transactionmanager', 'SellerController@transactionManager')->name('seller.transactionmanager');
    Route::get('/profile', 'SellerController@profile')->name('seller.profile');

    Route::resource('/transaction', 'TransactionController');

    Route::put('profile/{id}', 'SellerController@update');
    Route::get('profile/{id}/edit', 'SellerController@edit');

    Route::get('/seller_send_mail', 'CustomerController@seller_send_mail');
    Route::get('/frm_check_mail', 'CustomerController@frm_check_mail');
    Route::get('/check_mail', 'CustomerController@check_mail')->name('check_mail');
    Route::resource('/customermanager', 'Seller\CustomerManagerController');
    Route::resource('/bill','BillController');

    Route::get('/bill/detail/{id}', 'ManagerController@billDetail')->name('seller.bill-detail');

});

Route::get('test','HomeController@test');
