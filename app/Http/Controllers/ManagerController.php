<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }

    public function index()
    {
        return view('seller.index');
    }

    public function adminHome()
    {
        return view('admin.index');
    }
}
