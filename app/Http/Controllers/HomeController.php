<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HttpException;
use Illuminate\Http\Request;
use App\payment;
use App\Bill;
use App\Bill_Product;
use App\Feedback;
use App\Jobs\SendCusEmail;
use App\Mail\CusMail;
use Illuminate\Support\Facades\DB;
use Error;
use Stripe;
use Cart;
use Exception;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use PhpOption\None;

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

// Profile
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
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $data = payment::where('user_id', '=', $id)->select(DB::raw('RIGHT(number_card,4) as number_card'), 'id', 'exp_month', 'exp_year')->get();
        return view('customer.profile')->with('data', $data);
    }
    public function paymentprofile_delete($id)
    {
        $data = payment::where('id', $id)->delete();
        return back();
    }

    public function paymentprofile_edit(Request $request)
    {
        $apikey = env("STRIPE_API_KEY");
        Stripe\Stripe::setApiKey($apikey);
        $exp_month = $request->exp_month;
        $exp_year = $request->exp_year;
        $card_number = $request->number_card;
        $data = Payment::where('number_card', 'like', '%' . $card_number)->select('id', 'number_card', 'cvc', 'exp_month', 'exp_year')->first();
        try {
            $test = Stripe\Token::create([
                'card' => [
                    'number' => $data->number_card,
                    'exp_month' => $exp_month,
                    'exp_year' => $exp_year,
                    'cvc' => $data->cvc,
                ],
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            $error = $e->getError()->message;
            return redirect('profile')->with('status', "Edit Erorr: " . $error);
        }
        $data->exp_month = $exp_month;
        $data->exp_year = $exp_year;
        $data->save();
        return response()->json([
            'success' => 'Update Complete !!!!!'
        ]);
    }

// Cart----=-=========
    public function create_bill(Request $request)
    {
        $card_number = $request->card_number;
        $item = Cart::subtotal();
        $vowels = ",";
        $amount = str_replace($vowels, "", "$item");
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $apikey = env("STRIPE_API_KEY");
        $data = payment::where('number_card', 'like', '%' . $card_number)->select('number_card', 'cvc', 'exp_month', 'exp_year')->first();
        try {
            Stripe\Stripe::setApiKey($apikey);
            $Stoken = Stripe\Token::create([
                'card' => [
                    'number' => $data->number_card,
                    'exp_month' => $data->exp_month,
                    'exp_year' => $data->exp_year,
                    'cvc' => $data->cvc,
                ],
            ]);
            $Scharge = Stripe\Charge::create([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $Stoken->id,
                "description" => "Test payment from itsolutionstuff.com.",
            ]);
            $bill = new Bill();
            $bill->user_id = $user_id;
            $bill->total_money = $amount;
            $bill->save();
            foreach (Cart::content() as $row) {
                $bill_product = new Bill_Product();
                $bill_product->amount_licenses = $row->qty;
                $bill_product->pro_id = $row->id;
                $bill_product->bill_id = $bill->id;
                $bill_product->save();
                $qty = $row->qty;
                $product = Product::find($row->id)->increment('buy', $qty);
            }


            $details = [
                'title' => 'Thank you !!!!!',
                'total' => $amount,
                'date' => $bill->created_at,
                'card' => $card_number,
                'status' => $Scharge->outcome->seller_message,
                'email' => $user_email,
                'bill_detail' => Cart::content()
            ];

            dispatch(new SendCusEmail($details));
            Cart::destroy();
            return response()->json([
                'success' => $Scharge->outcome->seller_message
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
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
                'success' => "Payment Error !!!!!"
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
                'success' => "Card is empty !!!!"
            ]);
        }
    }

// Bills ======= = = = = = == =
    public function list_bills()
    {
        $id = Auth::user()->id;
        $bill = Bill::where('user_id', $id)->with('managers')->get();
        return view('customer.cus_list_bills')->with('bill', $bill);
    }

    public function bill_detail($id)
    {
        $data = Bill_Product::with('products:id,name_pro,price_license')->where('bill_id', $id)->get();
        return view('customer.cus_bill_detail')->with('data', $data);
    }
    public function feedback_add(Request $request)
    {
        $seller_id = $request->seller_id;
        $title = $request->title;
        $des = $request->des;
        $user_id = Auth::user()->id;

        $data = new Feedback();
        $data->title = $title;
        $data->description = $des;
        $data->seller_id = $seller_id;
        $data->user_id = $user_id;
        $data->save();
        return response()->json([
            'status' => "Complete !!!",
        ]);
    }

    public function feedback_index()
    {
        $user_id = Auth::user()->id;
        $data = Feedback::where('user_id', $user_id)->with(['managers', 'users'])->get();
        return view('customer.cus_feedback')->with('data', $data);
    }

    public function test(){
        $stripe = new \Stripe\StripeClient(env("STRIPE_API_KEY"));
          $test = $stripe->tokens->create([
            'card' => [
              'number' => '4242424242424242',
              'exp_month' => 8,
              'exp_year' => 2021,
              'cvc' => '314',
            ],
          ]);
          return $test;
    }
}
