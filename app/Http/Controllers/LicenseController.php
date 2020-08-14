<?php

namespace App\Http\Controllers;

use App\Bill_Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\License;
use App\Bill;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class LicenseController extends Controller
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
        $validatedData = $request->validate([
            'product_key' => ['required', 'string', 'max:50', 'unique:licenses'],
            'activation_date' => ['required'],
            'expiration_date' => ['required'],
            'pro_id' => ['required'],
            'user_id' => ['required'],
            'seller_id' => ['required'],
        ]);

        License::create([
            'product_key' => $request->product_key,
            'activation_date' => $request->activation_date,
            'expiration_date' => $request->expiration_date,
            'pro_id' => $request->pro_id,
            'user_id' => $request->user_id,
            'seller_id' => $request->seller_id,
        ]);    

        return redirect()->back()->with('success', 'Product key has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licenses = License::with(['users', 'managers'])->where('pro_id', $id)->get();
        $bills = Bill_Product::with('bills')->where('pro_id', $id)->get();
        return view('admin/license-key', [
            'licenses' => $licenses,
            'bills' => $bills,
            'id' => $id,
        ]);
    }

    public function get_bill(Request $request)
    {
        $bill_id = $request->id;
        $bills = Bill::where('id', $bill_id)
            ->with(['users', 'managers'])->get();
        return response()->json($bills);
    }

    public function create_key()
    {
        $key = Str::random(20);
        return Response::make($key);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $license = License::findOrFail($id);
        $licenses = License::with(['users', 'managers'])->where('id', $id)->get();
        // return Response::make($license);
        return response()->json($licenses);
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
        $validatedData = $request->validate([
            'product_key' => ['required', 'string', 'max:50', 'unique:licenses,product_key,' .$id],
            'activation_date' => ['required'],
            'expiration_date' => ['required'],
            'user_id' => ['required'],
            'seller_id' => ['required'],
        ]);

        $license = License::findOrFail($id);
        $license->product_key =  $request->product_key;
        $license->activation_date = $request->activation_date;
        $license->expiration_date = $request->expiration_date;
        $license->user_id =  $request->user_id;
        $license->seller_id =  $request->seller_id;
        $license->save();

        return redirect()->back()->with('success', 'Licenses has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $license = License::findOrFail($id);
        $license->delete();
        return redirect()->back()
            ->with('success', 'Product key deleted successfully');
    }
}
