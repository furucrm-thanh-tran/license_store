<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill;
use Illuminate\Support\Facades\Auth;
use App\Bill_Product;
use App\License;
use App\Jobs\SendLicenseEmail;

class BillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $list = Bill_Product::with(['products:id,name_pro,price_license'])->where('bill_id', $id)->get();
        return view('bill-detail', ['list' => $list]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bills = Bill::where([['seller_id', Auth::guard('manager')->user()->id], ['user_id', $id]])
            ->with(['users', 'managers'])->get();
        return view('seller.bill', [
            'bills' => $bills,
        ]);
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
        $email = Bill::with(['users', 'managers'])->where('id', $id)->first();
        $licenses = License::with('products')->where('bill_id', $id)->orderBy('pro_id', 'asc')->get();

        $details = [
            'email' => $email,
            'licenses' => $licenses
        ];

        dispatch(new SendLicenseEmail($details));
        return redirect()->back();

        $bill = Bill::findOrFail($id);
        $bill->status = 1;
        $bill->save();
        return redirect()->back();
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
}
