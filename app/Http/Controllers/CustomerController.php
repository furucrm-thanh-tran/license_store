<?php

namespace App\Http\Controllers;

use App\Bill_Product;
use App\User;
use App\Payment;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use Stripe;
use Cart;
use Exception;

use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

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
    public function insert_view($id)
    {
        $product = Product::find($id);
        $view = $product->view;
        $product->view = $view+1;
        $product->save();
        $newview = $product->view;
        return response::make($newview);
    }
    public function index_new()
    {
        $product = Product::orderBy('created_at', 'desc')->get();
        return view('home')->with('product', $product);
    }
    public function index_update()
    {
        $product = Product::orderBy('updated_at', 'desc')->get();
        return view('home')->with('product', $product);
    }

    public function index_view()
    {
        $product = Product::orderBy('view', 'desc')->get();
        return view('home')->with('product', $product);
    }
    public function index_buy()
    {
        $product = Bill_Product::select('id','amount_licenses','pro_id')->get();
        foreach($product as $p){
            $n = $p->pro_id;
            echo $p;
        }

    }
}
