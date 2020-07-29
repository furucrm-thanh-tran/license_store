<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }

    public function customerManager()
    {
        return view('seller.customer');
    }


    public function productManager()
    {
        return view('seller.product');
    }

    public function transactionManager()
    {
        return view('seller.transaction');
    }

    public function profile()
    {
        return view('seller.profile');
    }

    public function bill()
    {
        return view('seller.bill');
    }
}
