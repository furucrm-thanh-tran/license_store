<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Jobs\SendSellerEmail;

class CustomerManagerController extends Controller
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
        $customers = Bill::where('seller_id', Auth::guard('manager')->user()->id)
            ->with(['users', 'managers'])
            ->select('user_id', DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->get();

        return view('seller.customer', [
            'customers' => $customers,
        ]);
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
        $bill = Bill::find($id);
        $bill->status = 1;
        $bill->save();
        return back();
    }

    public function seller_send_mail(Request $request){
        $user_email = $request->email;
        $seller_email = Auth::guard('manager')->user()->email;
        $details = [
            'title' => 'New Product !!!!',
            'user_email' => $user_email,
            'seller_email'=>$seller_email,
            'link'=>'http://127.0.0.1:8000/frm_check_mail'
        ];
        // dispatch(new SendSellerEmail($details));
        return response()->json('Send mail to '.$user_email .' complete');        
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
        //
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
