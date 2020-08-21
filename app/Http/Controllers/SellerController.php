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
        $sellermanager = Manager::where([['id', $id],['role', 0]])->get();
        return response()->json($sellermanager[0]);
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
