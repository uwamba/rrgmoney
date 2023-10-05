<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Send;
use App\Models\Topup;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:send-list|send-create|send-edit|send-delete', ['only' => ['index']]);
        $this->middleware('permission:send-create', ['only' => ['create','store']]);
        $this->middleware('permission:send-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:send-delete', ['only' => ['destroy']]);

    }

    public function index()
    {

        $sents = Send::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
       
       // dd( $topups);
       // $user=User::where('id', $topups->user_id)->get();
        return view('customer.send.index', ['sents' => $sents]);
    }
    public function admin_index()
    {

        $sents = Send::orderBy('id','DESC')->paginate(10);
       
       // dd( $topups);
       // $user=User::where('id', $topups->user_id)->get();
        return view('send.index', ['sents' => $sents]);
    }
    public function find(Request $request)
    {
        $query = $request->get('mobile_number');
        $user=User::join('currencies', 'currencies.currency_country', '=', 'users.country')->where('users.mobile_number', $query)->skip(0)->take(1)->get();


        return json_encode(array('data'=>$user));
  
        //return response()->json($user);
       
    }
    public function received()
    {

        $sents = Send::join('users', 'users.id', '=', 'sends.receiver_id')->where('receiver_id',Auth::user()->id)->get();
       // $flat_rate = flate_rate::join('currencies', 'currencies.id', '=', 'flate_rates.currency_id')->paginate(10);
       
       // dd( $topups);
       // $user=User::where('id', $topups->user_id)->get();
        return view('customer.send.received', ['sents' => $sents]);
    }
    public function create()
    {
        $roles = Role::all();
       // dd( Auth::user()->country);
        $row= DB::table('currencies')
        ->where('currency_country', '=', Auth::user()->country)
        ->first();
        $rate=$row->currency_ratio;
        $pricing_plan=$row->pricing_plan;
        $percentage=$row->charges_percentage;
        $user_currency=$row->currency_name;
        $countries = DB::table('countries')->get();
         $currencies = DB::table('currencies')->get();

        $flat_rate= DB::table('flate_rates')
        ->where('currency_id', '=', $row->id)
        ->get();
       
        return view('customer.send.add', ['roles' => $roles,'countries'=>$countries,'currencies'=>$currencies,'rate'=>$rate,'flate_rates'=>$flat_rate,'pricing_plan'=>$pricing_plan,'percentage'=>$percentage,'user_currency'=>$user_currency]);
    }
    public function getCountry()
    {
        $countries = Country::all();
       
        return $countries;
    }
    public function getRate($id)
    {
        $row= DB::table('currencies')
        ->where('currency_name', '=', $id)
        ->first();
        $rate=$row->currency_ratio;
      
        return $rate;
       
    }

    //store topup informtion in database table

    public function store(Request $request)
    {
        //begen transaction 

        DB::beginTransaction();
        try {
            $request->validate([
                'amount_foregn_currency'       => 'required|numeric',
                'amount_local_currency'     => 'required|numeric',
            ]);
            //verfy sender id
            $row= DB::table('users')
            ->where('mobile_number', '=', $request->phone)
            ->first();

            //verfy sender balance

            
            $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after ?? 0;
            $total_amount=$request->amount + $request->charges_h;
            
            if($balance< $total_amount){
                return redirect()->back()->withInput()->with('error', " you dont' have enough money to send");   
            }

            $currency= DB::table('currencies')
            ->where('currency_country', '=', Auth::user()->country)
            ->first()->currency_name;
            
            //deduct sent amount from account
            $topup = Topup::create([
                'amount'    => $request->amount_local_currency,
                'payment_type'   => "amount transfered",
                'currency'  => $currency,
                'reference' => $request->phone,
                'user_id' => auth::user()->id,
                'balance_before' => $balance,
                'balance_after' => $balance-$request->amount_local_currency,
            ]); 
            $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after;
           //register ransaction in topup table
            $topup = Topup::create([
                'amount'    => $request->charges_h,
                'payment_type'   => "transfer fees",
                'currency'  => $currency,
                'reference' => $request->phone,
                'user_id' => auth::user()->id,
                'balance_before' => $balance,
                'balance_after' => $balance-$request->charges_h,
            ]); 
            //reduce amount to sender account



            if($row){
                $sent = Send::create([
        
                    'amount_foregn_currency'=> $request->amount_foregn_currency,
                    'amount_local_currency'=> $request->amount_local_currency,
                    'charges'=> $request->charges_h,
                    'currency'=> $request->currency,
                    'reception_method'=> "null",
                    'names'=> $request->names,
                    'passport'=> "null",
                    'phone'=> $request->phone,
                    'email'=> $request->email,
                    'address1'=> $request->address,
                    'user_id'=> Auth::user()->id,
                    'sender_id'=> Auth::user()->id,
                    'receiver_id'=> $row->id,
                    'balance_before'=> $balance,
                    'balance_after'=> $balance-$request->amount_local_currency,
                    'bank_account'=>"null",
                    'bank_name'=> "null",
                    'unread'=> '1',
                    'passcode'=> Str::random(10),
                ]); 
               $receiver_balance=0;

               
                $balance = Topup::where('user_id',$row->id)->orderBy('id', 'desc')->first()->balance_after ?? $receiver_balance ;
                //add amount to account
                $topup = Topup::create([
                    'amount'    => $request->amount_foregn_currency,
                    'payment_type'   => "amount received",
                    'currency'  => $request->currency,
                    'reference' => $request->phone,
                    'user_id' => $row->id,
                    'balance_before' => $balance,
                    'balance_after' => $balance+$request->amount_foregn_currency,
                ]); 

    
                // Commit And Redirected To Listing
                DB::commit();

                
                $sents = Send::where('user_id',Auth::user()->id)->paginate(10);
                return view('customer.send.index', ['sents' => $sents,'success','sent Successfully.']);
            }else{
                return redirect()->back()->withInput()->with('error', "receiver not found!! please check receiver phone number if is in the system and try again or contact administrator");   
            }

            // Store Data
            
 
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    //
}
