<?php

namespace App\Http\Controllers;
use App\User;
use App\Payment;
use App\Product;
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

    public function index()
    {
        $product = product::all();
        return view('index')->with('product', $product);
        // foreach ($product as $product) {
        //     echo $product->name_pro ."<br>";
        // }
    }



    public function email()
    {
        return view('emails.SendMail');
    }


