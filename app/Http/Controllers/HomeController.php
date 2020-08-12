<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\payment;
use App\Bill;
use App\Bill_Product;
use Illuminate\Support\Facades\DB;
use Error;
use Stripe;
use Cart;
use Exception;
use Validator;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product = Product::all();
        return view('home')->with('product', $product);
    }
    function fetch_icon($icon_id)
    {
        $icon = Product::findOrFail($icon_id);

        $icon_file = Image::make($icon->icon_pro);

        $response = Response::make($icon_file->encode('jpeg'));
        return $response;
    }
    // public function index_new()
    // {
    //     $product = Product::orderBy('created_at', 'desc')->get();
    //     return view('home')->with('product', $product);
    // }
    // public function index_update()
    // {
    //     $product = Product::orderBy('updated_at', 'desc')->get();
    //     return view('home')->with('product', $product);
    // }

    // public function index_view()
    // {
    //     $product = Product::orderBy('view', 'desc')->get();
    //     return view('home')->with('product', $product);
    // }

    public function frm_insertcard()
    {
        return view('customer.insert_card');
    }

    public function insertcard(Request $request, $id)
    {
        $apikey = env("STRIPE_API_KEY");
        Stripe\Stripe::setApiKey($apikey);
        $validator = $request->validate([
            'number_card' => 'required|unique:payments',
        ]);
        $payment = new Payment();
        $payment->name_card = $request->card_name;
        $payment->number_card = $request->number_card;
        $payment->cvc = $request->card_cvc;
        $payment->exp_month = $request->card_expmonth;
        $payment->exp_year = $request->card_expyear;
        $payment->user_id = $id;
        $payment->save();
        return redirect()->route('profile');
        // return redirect()->route('profile');
    }

    public function profile()
    {
        try {
            $id = Auth::user()->id;
            $data = payment::where('user_id', '=', $id)->select(DB::raw('RIGHT(number_card,4) as number_card'),'id','exp_month', 'exp_year')->get();
            return view('customer.profile')->with('data', $data);
        } catch (Error $e) {
            return redirect()->route('frm_insertcard');
        }
    }
    public function paymentprofile_delete($id)
    {
        $data = payment::where('id', $id)->delete();
        return back();
    }

    public function paymentprofile_edit(Request $request){
        $apikey=env("STRIPE_API_KEY");
        Stripe\Stripe::setApiKey($apikey);
        $exp_month = $request->card_expmonth;
        $exp_year = $request->card_expyear;
        $card_number = $request->card_number;
        $data = Payment::where('number_card', 'like', '%' . $card_number)->select('id','number_card', 'cvc','exp_month','exp_year')->first();
        try{
            $test=Stripe\Token::create([
                'card' => [
                  'number' => $data->number_card,
                  'exp_month' => $exp_month,
                  'exp_year' => $exp_year,
                  'cvc' => $data->cvc,
                ],
              ]);
        }catch(\Stripe\Exception\CardException $e){
            $error = $e->getError()->message;
            return redirect('profile')->with('status',"Edit Erorr: " .$error);
        }
          $data->exp_month = $exp_month;
          $data->exp_year = $exp_year;
          $data->save();
          return back();
    }


    // Cart
    public function shopping_cart(Request $request)
    {
        $id = Auth::user()->id;
        $data = payment::where('user_id', '=', $id)
            ->select(DB::raw('RIGHT(number_card,4) as number_card'))->get();
        //   return $data;
        return view('customer.shopping_cart')->with('data', $data);
    }

    public function add_cart_item($id, $name, $qty, $price)
    {
        $data = Cart::add($id, $name, $qty, $price);
    }
    public function upd_cart_item($id, $qty)
    {
        $rowId = $id;
        Cart::update($rowId, $qty);
    }

    public function del_cart_item($id)
    {
        $rowId = $id;
        Cart::remove($rowId);
    }
    public function create_bill(Request $request)
    {
        $card_number = $request->card_number;
        $amount = $request->amount;
        $user_id = $request->user_id;
        $user_email = Auth::user()->email;
        $apikey = env("STRIPE_API_KEY");
        // return $card_number ." " .$amount ." " .$user_id;
        $data = payment::where('number_card', 'like', '%' . $card_number)->select('number_card', 'cvc', 'exp_month', 'exp_year')->first();
        // return $data;
        try {
            Stripe\Stripe::setApiKey($apikey);
            $Stoken = Stripe\Token::create([
                'card' => [
                    'number' => $data->number_card,
                    'cvc' => $data->cvc,
                    'exp_month' => $data->exp_month,
                    'exp_year' => $data->exp_year,
                ],
            ]);
            //   return $Stoken;

            $Scharge = Stripe\Charge::create([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $Stoken->id,
                "description" => "Test payment from itsolutionstuff.com.",
            ]);
            // return $Scharge->outcome->seller_message;
            // return $Scharge;
            $bill = new Bill();
            $bill->user_id = $user_id;
            $bill->total_money = $amount;
            $bill->save();
            foreach (Cart::content() as $row) {
                // echo $row->id ." " .$row->name ." " .$row->qty ." " .$row->price ." ";
                $bill_product = new Bill_Product();
                $bill_product->amount_licenses = $row->qty;
                $bill_product->pro_id = $row->id;
                $bill_product->bill_id = $bill->id;
                $bill_product->save();
            }




            $details = [
                'title' => 'Thank you !!!!!',
                'total' => $amount,
                'date' => $bill->created_at,
                'card' => $card_number,
                'status' => $Scharge->outcome->seller_message
            ];

            \Mail::to($user_email)->send(new \App\Mail\SendMail($details));
            Cart::destroy();
            return response()->json([
                'success' => $Scharge->outcome->seller_message
            ]);
            // return $product->id ." " .$product->name ." " .$product->qty ." " .$product->price;
            // return $product;
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            'Status is:' . $e->getHttpStatus() . '<br>';
            'Load:' . $e->getError()->load . '<br>';
            'Type is:' . $e->getError()->type . '<br>';
            'Code is:' . $e->getError()->code . '<br>';
            // param is '' in this case
            'Param is:' . $e->getError()->param . '<br>';
            'Status:' . ' failed' . '<br>';
            'Message is:' . $e->getError()->message . '<br>';
            // return Session::flash('erorr', $e->getError()->message);
            return response()->json([
                'success' => $e->getError()->message
            ]);
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            return "e1";
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            return response()->json([
                'success' => "Cart is empty"
            ]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return "Authentication with Stripe's API failed";
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            return "e4";
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return "e5";
        } catch (Exception $e) {
            return response()->json([
                'success' => "Card is empty !!!!!!!!"
            ]);
            // Something else happened, completely unrelated to Stripe
        }
    }

    public function list_bills($id)
    {
        $bill = Bill::with('bill__products:id,amount_licenses,pro_id,bill_id', 'products:name_pro,price_license')->where('user_id', $id)->get();
        return view('customer.cus_list_bills')->with('bill', $bill);
        // return $bill[0]." " .$bill[0]->products[0] ." " .$bill[0]->bill__products[0];

    }

    public function bill_detail($id)
    {
        $data = Bill_Product::with('products:id,name_pro,price_license')->where('bill_id', $id)->get();
        return view('customer.cus_bill_detail')->with('data', $data);
        // return $data[1]->products ." " .$data[1]->amount_licenses;
    }

}
