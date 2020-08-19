<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }

    public function transactionManager()
    {
        $transactions = Bill::with(['users', 'managers'])->get();
        $sellers_long = Manager::where('role', 0)->orderBy('created_at', 'desc')->take(5)->get();
        $sellers_best = Bill::with('managers')->whereNotNull('seller_id')->groupBy('seller_id') ->select( DB ::raw('seller_id , COUNT(*) as seller_count') )->limit(5)->get();
        return view('admin.transaction_manager', ['transactions' => $transactions, 'sellers_long' => $sellers_long, 'sellers_best' => $sellers_best]);
    }

    public function updateTransaction(Request $res, $id)
    {
        $bill = Bill::find($id);
        $bill->seller_id = $res->seller;
        $bill->save();
        return response([
            'bill' => $bill
        ], 200);
    }

    public function showProfile()
    {
        return view('admin.profile');
    }
}
