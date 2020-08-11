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

    function fetch_icon($icon_id)
    {
        $icon = Product::findOrFail($icon_id);

        $icon_file = Image::make($icon->icon_pro);

        $response = Response::make($icon_file->encode('jpeg'));
        return $response;
    }

    public function email()
    {
        return view('emails.SendMail');
    }
}
