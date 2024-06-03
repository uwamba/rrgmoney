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
use App\Mail\sendApprovedNotification;
use App\Mail\senderNotification;
use App\Mail\receiverNotification;
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

    public function index()
    {

        $sents = Send::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);

       // dd( $topups);
       // $user=User::where('id', $topups->user_id)->get();
        return view('customer.send.index', ['sents' => $sents]);
    }
    public function admin_index()
    {

       $sents = Send::join('users', 'sends.sender_id', '=','users.id' )
                            ->select('users.first_name','users.last_name','users.mobile_number','users.email as sender_email', 'sends.user_id','sends.charges','sends.amount_foregn_currency','sends.currency','sends.sender_id','sends.receiver_id','sends.names','sends.phone','sends.id','sends.created_at','sends.amount_local_currency','sends.amount_foregn_currency','sends.status','sends.created_at as created_on','sends.class','sends.description','sends.reception_method')
                            ->orderBy('sends.id','DESC')
                            ->paginate(10);

        return view('send.index', ['sents' => $sents]);
    }

     public function agent_transfer()
        {
            $sents = Send::join('users', 'sends.sender_id', '=','users.id' )
                     ->select('users.first_name','users.last_name','users.mobile_number','users.email as sender_email', 'sends.user_id','sends.charges','sends.amount_foregn_currency','sends.currency','sends.sender_id','sends.receiver_id','sends.names','sends.phone','sends.id','sends.created_at','sends.amount_local_currency','sends.amount_foregn_currency','sends.status','sends.created_at as created_on')
                     ->where('sends.user_id',Auth::user()->id)
                     ->where('sends.class','send')
                     ->orderBy('sends.id','DESC')
                     ->paginate(10);

            return view('agent.send.list', ['sents' => $sents]);
        }

     public function transfer()
        {

                $roles = Role::all();
               $row= DB::table('currencies')
                          ->where('currency_country', '=', Auth::user()->country)
                          ->first();
                       $rate=$row->currency_buying_rate;
                       $pricing_plan=$row->pricing_plan;
                       $percentage=$row->charges_percentage;
                       $user_currency=$row->currency_name;
                       $countries = DB::table('countries')->get();
                       $currencies = DB::table('currencies')->get();
                       $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after ?? 0;

                       $flat_rate= DB::table('flate_rates')
                          ->where('currency_id', '=', $row->id)
                          ->get();

             return view('agent.receive.transferReceive', ['roles' => $roles,'countries'=>$countries,'currencies'=>$currencies,'rate'=>$rate,'flate_rates'=>$flat_rate,'pricing_plan'=>$pricing_plan,'percentage'=>$percentage,'user_currency'=>$user_currency,'balance'=> $balance]);
        }

      public function transferNext(Request $request)
              {

                   $roles = Role::all();
                     $row= DB::table('currencies')
                                ->where('currency_country', '=', Auth::user()->country)
                                ->first();
                             $rate=$row->currency_buying_rate;
                             $pricing_plan=$row->pricing_plan;
                             $percentage=$row->charges_percentage;
                             $user_currency=$row->currency_name;
                             $country=$row->currency_country;
                             $countries = DB::table('countries')->get();
                             $currencies = DB::table('currencies')->get();
                             $accounts = DB::table('accounts')->get();
                             $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after ?? 0;

                             $flat_rate= DB::table('flate_rates')
                                ->where('currency_id', '=', $row->id)
                                ->get();

                   return view('agent.receive.transferNextReceive', ['roles' => $roles,'countries'=>$countries,'currencies'=>$currencies,'rate'=>$rate,'flate_rates'=>$flat_rate,'pricing_plan'=>$pricing_plan,'percentage'=>$percentage,'balance'=> $balance,'request'=>$request,'country'=> $country,'user_currency'=> $user_currency,'accounts'=>$accounts]);
              }
              public function calculator()
              {


                $row= DB::table('currencies')
                             ->where('currency_country', '=', Auth::user()->country)
                             ->first();
                 $rate=$row->currency_selling_rate;
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

                   return view('agent.calculator', ['countries'=>$countries,'currencies'=>$currencies,'rate'=>$rate,'flate_rates'=>$flat_rate,'pricing_plan'=>$pricing_plan,'percentage'=>$percentage,'user_currency'=>$user_currency,'balance'=> $balance,'country'=> $country]);
              }
    public function find(Request $request)
    {
        $query = $request->get('mobile_number');
        $user_id=User::where('mobile_number',$query )->get()->first()->id;
        $user_country=User::find($user_id)->country;

        $rate= DB::table('currencies')->where('currency_country', '=', $user_country)->first()->currency_ratio;
        $currency_name= DB::table('currencies')->where('currency_country', '=', $user_country)->first()->currency_name;

        $balance = Topup::where('user_id',$user_id)->orderBy('id', 'desc')->first()->balance_after ?? 0;

        $balance=number_format( $balance);

        $user=User::join('currencies', 'currencies.currency_country', '=', 'users.country')->where('users.mobile_number', $query)->skip(0)->take(1)->get();


        return json_encode(array('data'=>$user,'balance'=>$balance,'user_id'=>$user_id,'rate'=>$rate));

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

               return view('customer.send.add', ['roles' => $roles,'countries'=>$countries,'currencies'=>$currencies,'rate'=>$rate,'flate_rates'=>$flat_rate,'pricing_plan'=>$pricing_plan,'percentage'=>$percentage,'user_currency'=>$user_currency,'balance'=> $balance]);
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
            $total_amount=$request->amount_rw_currency + $request->charges_rw;
            $commission=$request->charges_rw * $commission_rate/100;
            $company_profit=$request->charges_rw - $commission;
            $Company_balance = Topup::where('user_id',0)->orderBy('id', 'desc')->first()->balance_after ?? 0;

            $agent_balance = DB::table('stocks')->where('user_id',Auth::user()->id)
                ->where(function ($query) {
                   $query->where('status','Approved')
                   ->orWhere('status','auto-approved');
                })
                 ->orderBy('sequence_number', 'desc')->first()->balance_after ?? 0;

             $senderEmail=User::find($request->sender_id)->email;
             $senderName=User::find($request->sender_id)->first_name;
             $receiverEmail=User::find($receiver->id)->email;
             $receiverName=User::find($receiver->id)->first_name;

           // add transaction in sent table

            if($row){

                $sent = Send::create([
                    'amount_foregn_currency'=> $request->amount_foregn_currency,
                    'amount_local_currency'=> $request->amount_local_currency,
                    'amount_rw'=> $request->amount_rw_currency,
                    'charges'=> $request->charges_rw,
                    'currency'=> $request->receiver_currency,
                    'local_currency'=> $request->sender_currency,
                    'reception_method'=> $request->payment,
                    'description'=> $request->details,
                    'class'=> "receive",
                    'names'=> $request->names,
                    'passport'=> "null",
                    'phone'=> $request->phone,
                    'email'=> $request->email,
                    'address1'=> $request->address,
                    'user_id'=> Auth::user()->id,
                    'sender_id'=> $request->sender_id,
                    'receiver_id'=> $request->receiver_id,
                    'balance_before'=> $agent_balance,
                    'balance_after_temp'=> $agent_balance-$request->amount_local_currency,
                    'bank_account'=>"none",
                    'bank_name'=> "none",
                    'unread'=> '1',
                    'passcode'=> Str::random(10),
                ]);
               $receiver_balance=0;
                $balance = Topup::where('user_id',$row->id)->orderBy('id', 'desc')->first()->balance_after ?? $receiver_balance ;

                //add fees to company account

                $topup_c = Topup::create([
                                   'amount'    => $company_profit,
                                   'payment_type'   => "Transfer Fees",
                                   'currency'  => $request->sender_currency,
                                   'reference' => auth::user()->id,
                                   'user_id' => 0,
                                   'balance_before' => $Company_balance,
                                   'balance_after_temp' => $balance+$company_profit,
                                   'status' => 'Pending',
                               ]);

                                $topup_a = Topup::create([
                                   'amount'    => $commission,
                                   'payment_type'   => "Commission Fees",
                                   'currency'  => $request->sender_currency,
                                   'reference' => auth::user()->id,
                                   'user_id' => auth::user()->id,
                                   'balance_before' => $Company_balance,
                                   'balance_after_temp' => $Company_balance+$commission,
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
                      'currency'  => $request->receiver_currency,
                      'details'  => $request->details,
                      'receiver_id' => auth::user()->id,
                      'transfer_id' =>$sent->id,
                      'balance_before' => $balance,
                      'balance_after' => $balance,
                 ]);
                // Commit And Redirected To Listing
                DB::commit();


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


                return redirect()->route('send.agent_transfer');
            }else{
                return redirect()->route('send.transfer')->with("error","receiver not found!! please check receiver phone number if is in the system and try again or contact administrator.");

            }



            }

            public function approve(Request $request)
              {
             try {
               //find the agent email
               $sender=User::find($request->agent_id)->email;
               //find the sender email
               $senderEmail=User::find($request->sender_id)->email;
               $senderName=User::find($request->sender_id)->first_name;
                //find receiver email
                $receiverEmail=User::find($request->receiver_id)->email;
                $receiverName=User::find($request->receiver_id)->first_name;

               //find topup id
                $topups=TopUpsSends::where('sends_id', $request->send_id)->get();
                foreach($topups as $topup) {
                $temp=Topup::find($request->topup_id)->balance_after_temp;
                 Topup::whereId($topups->topup_id)->where('balance_after','!=',0)->update(['status' => $request->status, 'balance_after'=>$temp,'agent'=>Auth::user()->id]);

                }
                $topBalance = Topup::where('user_id',$request->receiver_id)->orderBy('id', 'desc')->first()->balance_after ?? 0 ;
                cashout::where('transfer_id',$request->send_id)->update(['status' => $request->status, 'balance_after'=>$topBalance-$request->amount_foregn_currency ,'user_id'=>Auth::user()->id]);
                Send::whereId($request->id)->update(['status' => $request->status]);
                $stockBalance = Stock::where('user_id',$request->agent_id)->orderBy('id', 'desc')->first()->balance_after ?? 0;
                $class=Send::find($request->id)->class;
                $total=0;
                if($class="send"){
                $total=$stockBalance-$request->amount_local_currency;
                }else{
                 $total=$stockBalance+$request->amount_local_currency;
                }

                $userCountry=User::find($request->agent_id)->country;
                               $currency= DB::table('currencies')
                                          ->where('currency_country', '=', $userCountry)
                                          ->first()->currency_name;
                              $first_name=User::find($request->agent_id)->first_name;
                              $last_name=User::find($request->agent_id)->last_name;
                              $names= $first_name." ".$last_name;
                              $stock = Stock::create([
                                'amount'    => $request->amount_local_currency,
                               'entry_type'    => "Debit",
                               'amount_deposit'=>0,
                               'description'    => $names,
                               'balance_before'    => $stockBalance,
                               'balance_after'    => $total,
                               'given_amount'    => 0,
                               'currency'    =>  $currency,
                               'admin_id'    =>  Auth::user()->id,
                               'user_id'     => $request->agent_id,
                               'status'     => 'auto-approved',

                              ]);

               // Commit And Redirect on index with Success Message
               DB::commit();
               $mailData = [
                          'title' => 'Money received!',
                          'senderName' => $senderName,
                          'receiverName' => $receiverName,
                          'amount' => $request->amount_foregn_currency,
                      ];

               Mail::to($receiverEmail)->send(new sendApprovedNotification($mailData));


             return redirect()->route('send.transfer')->with("success","transfer approved Successfully!");

        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    //
}
