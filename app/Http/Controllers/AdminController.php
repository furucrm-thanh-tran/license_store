<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendAssigningEmail;
use App\Jobs\SendCustomerEmail;

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

    public function productManager()
    {
        return view('admin.product_manager');
    }

    public function showProfile()
    {
        return view('admin.profile');
    }

    public function admin_send_mail(Request $request){
        $details = [
            'customer_email' => $request->customer_email,
            'customer_name' => $request->customer_name,
            'seller_email'=> $request->seller_email,
            'seller_name'=> $request->seller_name,
            'bill_code' => $request->bill_code
        ];
        dispatch(new SendAssigningEmail($details));
        dispatch(new SendCustomerEmail($details));
        return response()->json('Send mail to '.$details['seller_email'].' and '.$details['customer_email'].' complete');
    }
}
