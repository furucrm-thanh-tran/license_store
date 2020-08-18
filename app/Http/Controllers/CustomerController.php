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
        $product=Product::orderBy('buy', 'desc')->get();
        return view('home')->with('product', $product);

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
    }

    // public function shopping_cart(Request $request)
    // {

    //     try{
    //         $id = Auth::user()->id;
    //         $data = payment::where('user_id', '=', $id)
    //         ->select(DB::raw('RIGHT(number_card,4) as number_card'))->get();
    //     return view('customer.shopping_cart')->with('data', $data);

    //     }catch(Exception $e){

    //         return view('auth.login');
    //     }

    // }
    public function upd_cart_item(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        $rowId = $id;
        Cart::update($rowId, $qty);
    }
    public function del_cart_item(Request $request)
    {
        $id = $request->id;
        $rowId = $id;
        Cart::remove($rowId);
    }

}
