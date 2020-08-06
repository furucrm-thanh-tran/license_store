<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }

    public function sellerManager()
    {
        return view('admin.seller_manager');
    }

    public function transactionManager()
    {
        return view('admin.transaction_manager');
    }

    public function productManager()
    {
        return view('admin.product_manager');
    }

    public function showProfile()
    {
        return view('admin.profile');
    }
}
