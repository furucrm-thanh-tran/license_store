<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Jobs\SendSellerEmail;
use Exception;
use PhpOption\None;
use Cart;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{

    public function edit_info_cus(Request $request, $id)
    {
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
    }
    public function email()
    {
        return view('emails.SendMail');
    }
    public function insert_view(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        $view = $product->view;
        $product->view = $view+1;
        $product->save();
        $newview = $product->view;
        return response::make($newview);
    }

    public function frm_check_mail(){
        return view('customer.cus_check_mail');
    }
    public function check_mail(Request $request){
        $email = $request->email;
        $data = User::where('email',$email)->first();
        if ($data!=null){
            return view('auth.login');
        }else{
            return view('auth.register');
        }

    }
    public function add_cart_item(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $qty = $request->qty;
        $price = $request->price;
        $data = Cart::add($id, $name, $qty, $price);
        return response()->json([
            'id' => $id,
            'name' => $name,
            'qty' => $qty,
            'price' => $price
        ]);
    }

    public function shopping_cart(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $cart = Cart::content();
            $data = payment::where('user_id', '=', $id)
            ->select(DB::raw('RIGHT(number_card,4) as number_card'))->get();
            return view('customer.shopping_cart')->with([
                'data'=> $data,
                'cart'=>$cart]);
        }catch(Exception $e){
            return $e;
        }

    }

}
