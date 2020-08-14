<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Jobs\SendSellerEmail;
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
        $product=Product::orderBy('buy', 'desc')->get();
        return view('home')->with('product', $product);

    }

    public function seller_send_mail(){
        $user_email ="hoailinh031098@gmail.com";
        $details = [
            'title' => 'New Product !!!!',
            'email'=>$user_email,
            'link'=>'http://127.0.0.1:8000/frm_check_mail'
        ];
        dispatch(new SendSellerEmail($details));
        return "It Work !!!!";
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

}
