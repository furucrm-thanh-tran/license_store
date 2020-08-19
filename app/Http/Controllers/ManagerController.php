<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Bill_Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function billDetail($id)
    {
        // $list = 0;
        //$list = DB::select('SELECT products.name_pro, products.price_license, bill__products.amount_licenses FROM bill__products JOIN products ON bill__products.pro_id = products.id JOIN bills ON bill__products.bill_id = bills.id WHERE bills.id = 1');

        $list = Bill_Product::with(['products:id,name_pro,price_license'])->where('bill_id', $id)->get();
        return view('bill-detail', ['list' => $list]);
        // dd($list);
        // return view('bill-detail', ['list' => json_encode($list)]);
        // return $list;
    }
}
