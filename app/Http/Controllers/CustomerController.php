<?php

namespace App\Http\Controllers;
use App\User;
use App\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use Stripe;
use Cart;
use Exception;
class CustomerController extends Controller
{
    public function edit_info_cus(Request $request, $id)
    {
        // $validator = $request->validate([
        //     'email'=>'required|unique:users',
        // ]);
        $cus = User::find($id);
        $cus->full_name = $request->name;
        $cus->phone = $request->phone;
        $cus->email = $request->email;
        $cus->save();
        return back();
    }




}
