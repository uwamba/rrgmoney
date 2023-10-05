<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Send;
use App\Models\safe_pay;
use App\Models\Topup;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SafePayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:safe_pay-list|safe_pay-create|safe_pay-edit|safe_pay-delete', ['only' => ['index']]);
        $this->middleware('permission:safe_pay-create', ['only' => ['create','store']]);
        $this->middleware('permission:safe_pay-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:safe_pay-delete', ['only' => ['destroy']]);

    }

    public function index()
    {

        $safe_pays =safe_pay::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);

        return view('customer.safe_pay.index', ['safe_pays' => $safe_pays]);
    }
    public function admin_index()
    {

        $safe_pays = safe_pay::orderBy('id','DESC')->paginate(10);

        return view('safe_pay.index', ['safe_pays' => $safe_pays]);
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

        $safe_pays = safe_pay::select('sender.first_name as sfname','sender.last_name as slname','safe_pays.created_at','safe_pays.amount_foregn_currency','safe_pays.reason')->Join('users as sender', 'sender.id', '=', 'safe_pays.user_id')->where('safe_pays.receiver_id',Auth::user()->id)->orderBy('safe_pays.id','DESC')->paginate(10);;

        //$sender=User::where('id', $safe_pays->user_id)->get();

        return view('customer.safe_pay.received', ['safe_pays' => $safe_pays]);
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

        return view('customer.safe_pay.add', ['roles' => $roles,'countries'=>$countries,'currencies'=>$currencies,'rate'=>$rate,'flate_rates'=>$flat_rate,'pricing_plan'=>$pricing_plan,'percentage'=>$percentage,'user_currency'=>$user_currency]);
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
                'upload' => 'required',
                'upload.*' => 'required|mimes:pdf,jpg,png,jpeg|max:2048',
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
                'payment_type'   => "payment fees",
                'currency'  => $currency,
                'reference' => $request->phone,
                'user_id' => auth::user()->id,
                'balance_before' => $balance,
                'balance_after' => $balance-$request->charges_h,
            ]);

                $file = $request->file('upload');
                $file_name = time().rand(1,99).'.'.$file->extension();
                $file->move(public_path('uploads'), $file_name);



            if($row){
                $sent = safe_pay::create([

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
                    'attachement'=>$file_name,
                    'reason'=>$request->reason,
                    'details'=>$request->details,
                ]);
               $receiver_balance=0;


                $balance = Topup::where('user_id',$row->id)->orderBy('id', 'desc')->first()->balance_after ?? $receiver_balance ;
                //add amount to account
                $topup = Topup::create([
                    'amount'    => $request->amount_foregn_currency,
                    'payment_type'   => "amount onhold",
                    'currency'  => $request->currency,
                    'reference' => $request->phone,
                    'user_id' => $row->id."_".Auth::user()->id,
                    'balance_before' => $balance,
                    'balance_after' => $balance+$request->amount_foregn_currency,
                ]);


                // Commit And Redirected To Listing
                DB::commit();


                $safe_pays = safe_pay::where('user_id',Auth::user()->id)->paginate(10);
                //return view('customer.safe_pay.index', ['safe_pays' => $safe_pays,'success','sent Successfully.']);
                return redirect()->route('safe_pay.index', ['safe_pays' => $safe_pays,'success','sent Successfully.']);
                //return redirect()->action('SafePayController@index', ['safe_pays' => $safe_pays,'success','sent Successfully.']);
            }else{

                return redirect()->back()->withInput()->with('error', "receiver not found!! please check receiver phone number if is in the system and try again or contact administrator");
            }

            // Store Data


        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
           // dd($th->getMessage());
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function updateStatus(Request $request)
    {


        // If Validations Fails


        try {
            DB::beginTransaction();

            // get user amount and current balance

            $amount = Topup::where('id',$request->id)->first()->amount;
            $balance = Topup::where('id',$request->id)->first()->balance_after;
            $total=$balance+$amount;
            //update amount and status
            Topup::whereId($request->id)->update(['status' => $request->status,'balance_after'=>$total,'Agent'=>Auth::user()->id]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('topup.admin_index')->with('success','topup Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
