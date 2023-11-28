<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Send;
use App\Models\Topup;
use App\Models\Stock;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Str;
use App\Mail\sendEmail;
use Illuminate\Support\Facades\Mail;

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
     public function agent_transfer()
        {
            $sents = Send::join('users', 'users.id', '=', 'sends.sender_id')
                     ->select('users.first_name','users.last_name','users.mobile_number', 'sends.user_id','sends.amount_foregn_currency','sends.currency','sends.sender_id','sends.receiver_id','sends.names','sends.phone','sends.id','sends.created_at','sends.amount_local_currency','sends.amount_foregn_currency','sends.status')
                     ->orderBy('sends.id','DESC')
                     ->paginate(10);

            return view('send.transfer', ['sents' => $sents]);
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

             return view('send.add', ['roles' => $roles,'countries'=>$countries,'currencies'=>$currencies,'rate'=>$rate,'flate_rates'=>$flat_rate,'pricing_plan'=>$pricing_plan,'percentage'=>$percentage,'user_currency'=>$user_currency,'balance'=> $balance]);
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
                             $countries = DB::table('countries')->get();
                             $currencies = DB::table('currencies')->get();
                             $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after ?? 0;

                             $flat_rate= DB::table('flate_rates')
                                ->where('currency_id', '=', $row->id)
                                ->get();

                   return view('send.addNext', ['roles' => $roles,'countries'=>$countries,'currencies'=>$currencies,'rate'=>$rate,'flate_rates'=>$flat_rate,'pricing_plan'=>$pricing_plan,'percentage'=>$percentage,'user_currency'=>$user_currency,'balance'=> $balance,'request'=>$request]);
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

          $data = [
          		'foo' => 'bar'
          	];
          	$pdf = PDF::loadView('send.receipt', $data);
          	return $pdf->stream('document.pdf');

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
            $row= DB::table('users')->where('mobile_number', '=', $request->phone)->first();

            //verfy sender balance


            $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after ?? 0;
            $total_amount=$request->amount_local_currency + $request->charges_h;
            //dd( $balance." ".$total_amount);
            if($balance< $total_amount){
                return redirect()->back()->withInput()->with('error', " you don't have enough money to send");
            }

            $currency= DB::table('currencies')
            ->where('currency_country', '=', Auth::user()->country)
            ->first()->currency_name;

            //deduct sent amount from account
            $topup = Topup::create([
                'amount'    => -$request->amount_local_currency,
                'payment_type'   => "amount transferred",
                'currency'  => $currency,
                'reference' => $request->phone,
                'user_id' => auth::user()->id,
                'balance_before' => $balance,
                'status' => 'Approved',
                'balance_after' => $balance-$request->amount_local_currency,
            ]);
            $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after;
           //register transaction in topup table
            $topup = Topup::create([
                'amount'    => -$request->charges_h,
                'payment_type'   => "transfer fees",
                'currency'  => $currency,
                'reference' => $request->phone,
                'user_id' => auth::user()->id,
                'balance_before' => $balance,
                'status' => 'Approved',
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
                    'sender_id'=> $request->address,
                    'receiver_id'=> $row->id,
                    'balance_before'=> $balance,
                    'balance_after_temp'=> $balance-$request->amount_local_currency,
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
                    'status' => 'Approved',
                    'balance_after' => $balance+$request->amount_foregn_currency,
                ]);
                // Commit And Redirected To Listing
                DB::commit();
                $sents = Send::where('user_id',Auth::user()->id)->paginate(10);


                return redirect()->route('send.index')->with(['sents' => $sents,'success','sent Successfully.']);
            }else{
                return redirect()->back()->withInput()->with('error', "receiver not found!! please check receiver phone number if is in the system and try again or contact administrator");
            }

            // Store Data


        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
        //send email notofications
        try{
             //send notification to sender
              $details = [
                 'title' => 'Transfer',
                  'body' => 'you transferred amount of '.$request->amount_local_currency.' to  '.$request->phone];
                   Mail::to(Auth::user()->email)->send(new sendEmail($details));

           //send notification to receiver
           $details = [
            'title' => 'Received',
             'body' => 'you received amount of '.$request->amount_foregn_currency.' from  '.$request->Auth::user()->email];
              Mail::to($request->email)->send(new sendEmail($details));
         }
        catch (\Throwable $th) {}
    }
     public function storeTransfer(Request $request)
        {
            //begen transaction

            DB::beginTransaction();
            try {
                $request->validate([
                    'amount_foregn_currency'       => 'required|numeric',
                    'amount_local_currency'     => 'required|numeric',
                ]);
                //verfy sender id
                $receiver= DB::table('users')->where('mobile_number', '=', $request->phone)->first();
                $sender= DB::table('users')->where('mobile_number', '=', $request->sender_phone)->first();


                $currency= DB::table('currencies')->where('currency_country', '=', $sender->country)->first()->currency_name;

                $stock_balance = Stock::orderBy('id','Desc')->where('balance_before', '!=' , 0)->first()->balance_before ?? 0;
                 $total=$stock_balance-$request->amount_local_currency;
                   $user = Stock::create([
                         'amount'    => $request->amount_local_currency,
                         'amount_deposit'    => 0,
                         'currency'    => $request->currency,
                         'entry_type'    => "Debit",
                         'description'    => "Stock movement",
                         'balance_before'    => $stock_balance,
                         'balance_after'    => $total,
                         'given_amount'    => $request->amount_local_currency,
                         'admin_id'    => 0,
                         'status'        => "Approved".$request->id,
                         'user_id'     => Auth::user()->id,
                        ]);

                           //get stock balance
                           $stock = Stock::where('user_id',Auth::user()->id)->where('currency',$request->currency)->orderBy('id','Desc')->first()->balance_after ?? 0;
                            if($stock<$request->amount_local_currency){
                            return redirect()->back()->with('error', 'you do not have stock '.$stock.' '.$request->currency);
                            }



                if($receiver){
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
                        'sender_id'=> $sender->id,
                        'receiver_id'=> $receiver->id,
                        'balance_before'=> $stock_balance,
                        'balance_after_temp'=> $stock_balance-$request->amount_local_currency,
                        'bank_account'=>"null",
                        'bank_name'=> "null",
                        'unread'=> '1',
                        'passcode'=> Str::random(10),
                    ]);
                   $receiver_balance=0;
                    $balance = Topup::where('user_id',$receiver->id)->orderBy('id', 'desc')->first()->balance_after ?? $receiver_balance ;

                    // Commit And Redirected To Listing
                    DB::commit();
                   $sents = Send::join('users', 'users.id', '=', 'sends.sender_id')->orderBy('sends.id','DESC')->paginate(10);

                    return redirect()->route('send.agent_transfer')->with(['sents' => $sents,'success','sent Successfully.']);
                }else{
                 return redirect()->route('send.transfer')->with('error', "receiver not found!! please check receiver phone number if is in the system and try again or contact administrator");

                }

                // Store Data


            } catch (\Throwable $th) {
                // Rollback and return with Error
                DB::rollBack();
               return redirect()->route('send.transfer')->with('error', $th->getMessage());
            }
            //send email notofications
            try{
                 //send notification to sender
                  $details = [
                     'title' => 'Transfer',
                      'body' => 'you transferred amount of '.$request->amount_local_currency.' to  '.$request->phone];
                       Mail::to(Auth::user()->email)->send(new sendEmail($details));

               //send notification to receiver
               $details = [
                'title' => 'Received',
                 'body' => 'you received amount of '.$request->amount_foregn_currency.' from  '.$request->Auth::user()->email];
                  Mail::to($request->email)->send(new sendEmail($details));
             }
            catch (\Throwable $th) {}
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
           //update status

            Send::whereId($request->id)->update(['status' => $request->status]);
            $balance = Topup::where('user_id',$request->receiver_id)->orderBy('id', 'desc')->first()->balance_after;

            //add amount to account
             $topup = Topup::create([
                'amount'    => $request->amount_foregn_currency,
                'payment_type'   => "amount received",
                'currency'  => $request->currency,
                'reference' => $request->id,
                'user_id' => $request->receiver_id,
                'balance_before' => $balance,
                'status' => 'Approved',
                'balance_after' => $balance+$request->amount_foregn_currency,
               ]);
            // Commit And Redirect on index with Success Message
            DB::commit();
            //send notification to agent
             $receiverEmailDetails = [
                          "title" => "Money Transfer",
                          "body" => " Hello ".$receiverName.",\n
                          Great news! The money transfer initiated by  ".$sender." .  has been successfully approved. the funds are with you now..
                           \n Thank you, \n
                           RRGMONEY"
                       ];
              Mail::to($receiverEmail)->send(new sendEmail($receiverEmailDetails));
            return redirect()->back()->with('success', 'transfer approved Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    //
}
