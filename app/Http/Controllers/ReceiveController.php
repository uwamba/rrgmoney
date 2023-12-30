<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Send;
use App\Models\Topup;
use App\Models\Cashout;
use App\Models\Stock;
use App\Models\Country;
use App\Models\Currency;
use App\Models\TopUpsSends;
use App\Models\Commission;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use \PDF;
use Illuminate\Support\Str;
use App\Mail\sendEmail;
use Illuminate\Support\Facades\Mail;

class ReceiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:send-list|send-create|send-edit|send-delete', ['only' => ['index']]);
        $this->middleware('permission:send-create', ['only' => ['create','store']]);
        $this->middleware('permission:send-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:send-delete', ['only' => ['destroy']]);

    }

  public function agent_transfer()
        {
            $sents = Send::join('users', 'sends.sender_id', '=','users.id' )
                     ->select('users.first_name','users.last_name','users.mobile_number','users.email as sender_email', 'sends.user_id','sends.charges','sends.amount_foregn_currency','sends.currency','sends.sender_id','sends.receiver_id','sends.names','sends.phone','sends.id','sends.created_at','sends.amount_local_currency','sends.amount_foregn_currency','sends.status','sends.created_at as created_on')
                     ->where('sends.user_id',Auth::user()->id)
                      ->where('sends.class','receive')
                     ->orderBy('sends.id','DESC')
                     ->paginate(10);

            return view('agent.receive.list', ['sents' => $sents]);
        }

     public function transfer()
        {

                $roles = Role::all();
               $row= DB::table('currencies')
                          ->where('currency_country', '=', Auth::user()->country)
                          ->first();
                       $rate=$row->currency_ratio;
                       $pricing_plan=$row->pricing_plan;
                       $percentage=$row->charges_percentage;
                       $user_currency=$row->currency_name;
                       $countries = DB::table('countries')->get();
                       $currencies = DB::table('currencies')->get();
                       $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after ?? 0;

                       $flat_rate= DB::table('flate_rates')
                          ->where('currency_id', '=', $row->id)
                          ->get();

             return view('agent.receive.transfer', ['roles' => $roles,'countries'=>$countries,'currencies'=>$currencies,'rate'=>$rate,'flate_rates'=>$flat_rate,'pricing_plan'=>$pricing_plan,'percentage'=>$percentage,'user_currency'=>$user_currency,'balance'=> $balance]);
        }

      public function transferNext(Request $request)
              {

                   $roles = Role::all();
                     $row= DB::table('currencies')
                                ->where('currency_country', '=', Auth::user()->country)
                                ->first();
                             $rate=$row->currency_ratio;
                             $pricing_plan=$row->pricing_plan;
                             $percentage=$row->charges_percentage;
                             $user_currency=$row->currency_name;
                             $country=$row->currency_country;
                             $countries = DB::table('countries')->get();
                             $currencies = DB::table('currencies')->get();
                             $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after ?? 0;

                             $flat_rate= DB::table('flate_rates')
                                ->where('currency_id', '=', $row->id)
                                ->get();

                   return view('agent.receive.transferNext', ['roles' => $roles,'countries'=>$countries,'currencies'=>$currencies,'rate'=>$rate,'flate_rates'=>$flat_rate,'pricing_plan'=>$pricing_plan,'percentage'=>$percentage,'user_currency'=>$user_currency,'balance'=> $balance,'request'=>$request,'country'=> $country]);
              }
    public function find(Request $request)
    {
        $query = $request->get('mobile_number');
        $user_id=User::where('mobile_number',$query )->get()->first()->id;
        $balance = Topup::where('user_id',$user_id)->orderBy('id', 'desc')->first()->balance_after ?? 0;
        $balance=number_format( $balance);

        $user=User::join('currencies', 'currencies.currency_country', '=', 'users.country')->where('users.mobile_number', $query)->skip(0)->take(1)->get();


        return json_encode(array('data'=>$user,'balance'=>$balance,'user_id'=>$user_id));

        //return response()->json($user);

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
    // get transfer receipt
     public function transferReceipt(Request $request)
        {



           $data=['request'=>$request,'agent'=>Auth::user()->first_name." ".Auth::user()->last_name];
          	 $pdf = PDF::loadView('send.receipt', $data,[],['format' => 'A5-L']);

             return $pdf->download('receipt.pdf');


        }

    //store topup informtion in database table
     public function store(Request $request)
        {
        }

    public function storeTransfer(Request $request)
    {
        //begen transaction

        DB::beginTransaction();

        //validation
            $request->validate([
                'amount_foregn_currency'       => 'required|numeric',
                'amount_local_currency'     => 'required|numeric',
            ]);
            //verfy sender id
             $receiver= DB::table('users')->where('mobile_number', '=', $request->phone)->first();
             $sender= DB::table('users')->where('mobile_number', '=', $request->sender_phone)->first();

            $row= DB::table('users')->where('mobile_number', '=', $request->phone)->first();

            //verify agent balance
            $my_currency= DB::table('currencies')
            ->where('currency_country', '=', Auth::user()->country)
            ->first()->currency_name;
             $balance = Stock::where('currency',$my_currency)->where('user_id',Auth::user()->id)->orderBy('id','Desc')->first()->balance_after ?? 0;
            //get commission rate
            $commission_rate = Commission::orderBy('id','Desc')->first()->rate ?? 0;
            //calculate total amount
            $total_amount=$request->amount_local_currency + $request->charges_h;
            $commission=$request->charges_h * $commission_rate/100;
            $company_profit=$request->charges_h-($request->charges_h * $commission_rate/100);
            $Company_balance = Topup::where('user_id',0)->orderBy('id', 'desc')->first()->balance_after ?? 0;
            if($balance< $total_amount){
                return redirect()->back()->withInput()->with('error', " you don't have enough money to send");

            }
             //get agent currency
            $currency= DB::table('currencies')
            ->where('currency_country', '=', Auth::user()->country)
            ->first()->currency_name;
             $receiver_country=User::find($request->receiver_id)->country;
             $receiver_currency= DB::table('currencies')
                        ->where('currency_country', '=', $receiver_country)
                        ->first()->currency_name;
           // add transaction in sent table

            if($row){
                $sent = Send::create([

                    'amount_foregn_currency'=> $request->amount_foregn_currency,
                    'amount_local_currency'=> $request->amount_local_currency,
                    'charges'=> $request->charges_h,
                    'currency'=> $request->currency,
                    'local_currency'=> $request->local_currency,
                    'reception_method'=> "null",
                    'class'=> "receive",
                    'names'=> $request->names,
                    'passport'=> "null",
                    'phone'=> $request->phone,
                    'email'=> $request->email,
                    'address1'=> $request->address,
                    'user_id'=> Auth::user()->id,
                    'sender_id'=> $request->sender_id,
                    'receiver_id'=> $request->receiver_id,
                    'balance_before'=> $balance,
                    'balance_after_temp'=> $balance-$request->amount_local_currency,
                    'bank_account'=>"null",
                    'bank_name'=> "null",
                    'unread'=> '1',
                    'passcode'=> Str::random(10),
                ]);
               $receiver_balance=0;
                $balance = Topup::where('user_id',$row->id)->orderBy('id', 'desc')->first()->balance_after ?? $receiver_balance ;

                //add fees to company account

                $topup_c = Topup::create([
                    'amount'    => $company_profit,
                    'payment_type'   => "Transfer Fees",
                    'currency'  => $request->currency,
                    'reference' => auth::user()->id,
                    'user_id' => 0,
                    'balance_before' => $Company_balance,
                    'balance_after_temp' => $Company_balance+$request->amount_local_currency,
                    'status' => 'Pending',
                ]);

                 $topup_a = Topup::create([
                    'amount'    => $commission,
                    'payment_type'   => "Commission Fees",
                    'currency'  => $request->currency,
                    'reference' => auth::user()->id,
                    'user_id' => auth::user()->id,
                    'balance_before' => $Company_balance,
                    'balance_after_temp' => $Company_balance+$request->amount_local_currency,
                    'status' => 'Pending',
                  ]);
                 $TopUpSend = TopUpsSends::create([
                  'topup_id'    => $topup_c->id,
                  'sends_id'   => $sent->id,
                  ]);
                 $TopUpSend = TopUpsSends::create([
                   'topup_id'    => $topup_a->id,
                   'sends_id'   => $sent->id,
                  ]);

                 // Store Data
                 $cashout = Cashout::create([
                      'amount'    => $request->amount_foregn_currency,
                      'method'   => $request->payment,
                      'currency'  => $receiver_currency,
                      'details'  => $request->details,
                      'receiver_id' => auth::user()->id,
                      'transfer_id' =>$sent->id,
                      'balance_before' => $balance,
                      'balance_after' => $balance,
                 ]);
                // Commit And Redirected To Listing
                DB::commit();
                return redirect()->route('receive.agent_transfer');
            }else{

                return redirect()->back()->withInput()->with('error', "receiver not found!! please check receiver phone number if is in the system and try again or contact administrator");
            }


            $senderEmail=User::find($request->sender_id)->email;
            $senderName=User::find($request->sender_id)->first_name;
            $receiverEmail=User::find($receiver->id)->email;
            $receiverName=User::find($receiver->id)->first_name;
            //send email notofications
              try{

              $mailData = [
               'title' => 'Money Transfer initiated!',
               'senderName' => $senderName,
               'receiverName' => $receiverName,
               'amount_f' => $request->amount_foregn_currency,
               'amount_l' => $request->amount_local_currency,

               ];

               Mail::to($senderEmail)->send(new senderNotification($mailData));


              //send notification to sender
              $mailData = [
                 'title' => 'Money Transfer initiated!',
                 'senderName' => $senderName,
                 'receiverName' => $receiverName,
                 'amount_f' => $request->amount_foregn_currency,
                 'amount_l' => $request->amount_local_currency,
                  ];

               Mail::to($receiverEmail)->send(new receiverNotification($mailData));
               }
               catch (\Throwable $th) {
               }
              }

    //
}
