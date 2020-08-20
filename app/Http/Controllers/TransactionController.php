<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendAssigningEmail;
use App\Jobs\SendCustomerEmail;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trans = Bill::with(['users', 'managers'])->orderBy('created_at', 'desc')->get();
        $sellers_long = Manager::where('role', 0)->orderBy('created_at', 'desc')->take(5)->get();
        $sellers_best = Bill::with('managers')->whereNotNull('seller_id')->groupBy('seller_id') ->select( DB::raw('seller_id , COUNT(*) as seller_count') )->limit(5)->get();
        $trans_data = array("trans" => $trans, "long" => $sellers_long, "best" => $sellers_best);
        return json_encode($trans_data);
        // return $trans;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $bill = Bill::find($id);
        // return json_encode($bill);
        return Bill::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bill = Bill::find($id);
        $bill->seller_id = $request->seller;
        $bill->save();
        return response([
            'bill' => $bill
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function send_mail(Request $request){
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
