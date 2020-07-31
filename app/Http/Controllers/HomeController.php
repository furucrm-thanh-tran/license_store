<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\payment;
use App\Product;
use Dotenv\Validator;
use Error;
use Stripe;
use Cart;
use Session;
use Exception;
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
        $product=product::all();
        return view('index')->with('product',$product);
        // foreach ($product as $product) {
        //     echo $product->name_pro ."<br>";
        // }

    }

    public function frm_insertcard()
    {
        return view('insert_card');
    }

    public function insertcard( Request $request, $id)
    {
        Stripe\Stripe::setApiKey("sk_test_51H7XCjBZo2jHPYhTsESBupsZkNosZPrTXD6cvkX9lflKz8Gue1lSYdmpiSv7imOXnwqgEsUwVMcqJ34nOblpuFAs005bYSJWOq");
        // $validator = $request->validate([
        //     'number_card'=>'required|unique:payments',
        // ]);
        // $card=Stripe\Customer::updateSource(
        //     'cus_HjITAbZNKVAGMU',
        //     'card_1HA8dVBZo2jHPYhTP8YYIkis',
        //     ['last4' => '0002']
        //   );
        $payment = new Payment();
        $payment->name_card = $request->card_name;
        $payment->number_card = $request->card_number;
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
        try{
        $id=Auth::user()->id;
        $data = payment::where('user_id','=',$id)->select('number_card','cvc','exp_month','exp_year')->get();
        return view('profile')->with('data',$data);
        }catch(Error $e){
            return redirect()->route('frm_insertcard');
        }
    }
    public function paymentprofile_delete($card_number)
    {
        $data = payment::where('number_card',$card_number)->delete();
        return back();
    }

    // Cart
    public function shopping_cart(Request $request){
        // $data=Cart::add('1', 'Product 1', 1, 9);
        // $data=Cart::add('2', 'Product 2', 1, 5);
        // $data=Cart::add('3', 'Product 3', 1, 5);
        // Cart::destroy();
        $id=Auth::user()->id;
        $data = payment::where('user_id','=',$id)
                        ->where('number_card','=','4242 4242 4242 4242')
                        // ->where('number_card','=','4000 0000 0000 0002')
                        ->select('name_card','number_card','cvc','exp_month','exp_year')->get();
        return view('shopping_cart')->with('data',$data);
    }


    public function add_cart_item($id,$name,$qty,$price)
    {
        $data=Cart::add($id, $name, $qty , $price);
    }


    public function upd_cart_item($id,$qty)
    {
        $rowId = $id;
        Cart::update($rowId,$qty);
    }

    public function del_cart_item($id)
    {
        $rowId = $id;
        Cart::remove($rowId);
        // Cart::update($rowId,4);
        // return response()->json([
        // 'success' => 'Record has been deleted successfully!'
        // ]);
    }

    public function pay_cart($amount,$card_number,$cvc,$exp_month,$exp_year)
    {
        try{
        Stripe\Stripe::setApiKey("sk_test_51H7XCjBZo2jHPYhTsESBupsZkNosZPrTXD6cvkX9lflKz8Gue1lSYdmpiSv7imOXnwqgEsUwVMcqJ34nOblpuFAs005bYSJWOq");
          $Stoken=Stripe\Token::create([
            'card' => [
              'number' => $card_number,
              'cvc' => $cvc,
              'exp_month' => $exp_month,
              'exp_year' => $exp_year,

            ],
          ]);


        $Scharge=Stripe\Charge::create ([
                "amount" => $amount*100,
                "currency" => "usd",
                "source" => $Stoken->id,
                "description" => "Test payment from itsolutionstuff.com.",
        ]);




        $Sretrieve=Stripe\Charge::retrieve([
            "id"=>$Scharge->id
            ]);
        return $Sretrieve;

    }catch(\Stripe\Exception\CardException $e) {
        // Since it's a decline, \Stripe\Exception\CardException will be caught
        'Status is:' . $e->getHttpStatus() . '<br>';
        'Load:' .$e->getError()->load .'<br>';
        'Type is:' . $e->getError()->type . '<br>';
        'Code is:' . $e->getError()->code . '<br>';
        // param is '' in this case
        'Param is:' . $e->getError()->param . '<br>';
        'Status:' .' failed' .'<br>';
        'Message is:' . $e->getError()->message . '<br>';
        Session::flash('erorr', $e->getError()->message);
        return back();



      } catch (\Stripe\Exception\RateLimitException $e) {
        // Too many requests made to the API too quickly
        return "e1";
      } catch (\Stripe\Exception\InvalidRequestException $e) {
        // Invalid parameters were supplied to Stripe's API
        Session::flash('erorr2', "Cart is empty");
        return back();
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
        return "e6";
        // Something else happened, completely unrelated to Stripe
      }
    //   $Sretrieve=Stripe\Charge::retrieve([
    //         "id"=>$test
    //         ]);

    //     return $Sretrieve;
    }




}
