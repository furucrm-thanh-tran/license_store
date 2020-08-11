<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;

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

    public function edit($id)
    {
        $sellermanager = Manager::findOrFail($id);
        return response()->json($sellermanager);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:managers,email,' .$id],           
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/(0)[0-9]{9}/', 'max:10']
        ]);

        $sellermanager = Manager::find($id);
        $sellermanager->full_name =  $request->full_name;
        $sellermanager->email = $request->email;
        $sellermanager->phone = $request->phone;
        $sellermanager->save();
        return redirect()->back()->with('success', 'Seller has been updated');
    }
}
