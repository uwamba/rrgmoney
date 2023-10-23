<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Cashout;
use App\Models\Currency;
use App\Models\Topup;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Exports\CashoutExport;
use Mail;
use App\Mail\sendEmail;
use Maatwebsite\Excel\Facades\Excel;

class CashoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:cashout-list|cashout-create|cashout-edit|cashout-delete', ['only' => ['index']]);
        $this->middleware('permission:cashout-create', ['only' => ['create','store']]);
        $this->middleware('permission:cashout-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:cashout-delete', ['only' => ['destroy']]);

    }

    /**
     * List topup
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function index()
    {

        $cashouts = DB::table('cashouts')->where('receiver_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
       // dd( $topups);
       // $user=User::where('id', $topups->user_id)->orderBy('id','DESC')->get();
        return view('customer.cashout.index', ['cashouts' => $cashouts]);
    }
    public function admin_index()
    {

        $cashouts = cashout::orderBy('id','DESC')->paginate(10);
        return view('cashout.index', ['cashouts' => $cashouts]);
    }
    public function create()
    {
        $roles = Role::all();

        return view('customer.cashout.add', ['roles' => $roles]);
    }

    //store topup informtion in database table

    public function store(Request $request)
    {
     DB::beginTransaction();
       $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after;
       $currency= DB::table('currencies')
       ->where('currency_country', '=', Auth::user()->country)
       ->first()->currency_name;


        try {
            $request->validate([
                'amount'       => 'required|numeric',
                'payment' => 'required',
                'details'    => 'required',

            ]);

            // Store Data
            $cashout = Cashout::create([
                'amount'    => $request->amount,
                'method'   => $request->payment,
                'currency'  => $currency,
                'details'  => $request->details,
                'receiver_id' => auth::user()->id,
                'balance_before' => $balance,
                'balance_after' => $balance,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            $cashouts = Cashout::where('receiver_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
            return view('cashout.index', ['cashouts' => $cashouts,'success','User Created Successfully.']);

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function updateStatus(Request $request)
    {


        // If Validations Fails


        try {
            DB::beginTransaction();

            // get user amount and current balance

            $amount = Cashout::where('id',$request->cashout_id)->first()->amount;

            $balance = Topup::where('user_id',$request->receiver_id)->orderBy('id','desc')->first()->balance_after;
            $total=$balance+$amount;
            // get user details
            $user_row= DB::table('users')->where('id', '=', $request->receiver_id)->first();

             $details = [
                             'title' => 'Cashout',
                              'body' => 'The amount of '.$amount.' debited from your RRGMONEY .'];
                               Mail::to($user_row->email)->send(new sendEmail($details));



                        Mail::to($request->email)->send(new SendEmail($MailData));
            $user_country = User::where('id',$request->receiver_id)->first()->country;

        $row= DB::table('currencies')
        ->where('currency_country', '=', $user_country)
        ->first();
        $rate=$row->currency_ratio;
        $pricing_plan=$row->pricing_plan;
        $percentage=$row->charges_percentage;
        $user_currency=$row->currency_name;

        $flat_rate= DB::table('flate_rates')
        ->where('currency_id', '=', $row->id)
        ->get();
        $charges=0;

        if ($pricing_plan == 'percentage') {
          $charges =$percentage * $amount / 100;
        } else if($pricing_plan == 'flat_rate_rate'){
            foreach($flat_rate as $rate){

                if ($amount>= $rate->from_amount && $amount <= $rate->to_amount) {
                    $charges=$rate->charges_amount_cashout;
                }
            }
        }else if($pricing_plan == 'flat_rate_percentage'){
            foreach($flat_rate as $rate){

                if ($amount>= $rate->from_amount && $amount <= $rate->to_amount) {
                    $charges=$rate->charges_amount_percentage_cashout;
                }
            }
        }else{
            return redirect()->back()->with('error', "No Pricing Plan Found");
        }
       //deduct amount from user account
            $topup = Topup::create([
                'amount'    =>-$amount,
                'payment_type'   => "amount transfered",
                'currency'  => $user_currency,
                'reference' => "cashout request id:".$request->cashout_id,
                'user_id' => $request->receiver_id,
                'balance_before' => $balance,
                'balance_after' => $balance-$amount,
            ]);

          //deduct charges from his account balance

         $balance = Topup::where('user_id',$request->receiver_id)->orderBy('id','desc')->first()->balance_after;
            $topup = Topup::create([
                'amount'    =>-$charges,
                'payment_type'   => "transfer Fees",
                'currency'  => $user_currency,
                'reference' => "Transfer Fees:".$request->cashout_id,
                'user_id' => $request->receiver_id,
                'balance_before' => $balance,
                'balance_after' => $balance-$charges,
            ]);



            Cashout::whereId($request->cashout_id)->update(['status' => $request->status,'user_id'=>Auth::user()->id,'charges'=>$charges]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('cashout.admin_index')->with('success',' Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function comment(Request $request)
    {

        DB::beginTransaction();
        try {
            Cashout::whereId($request->cashout_id)->update(['admin_message' => $request->description,'user_id'=>Auth::user()->id,'status' => $request->status,]);
            DB::commit();
      //get user details
        $user_row= DB::table('users')->where('id', '=', $request->receiver_id)->first();

            $MailData = [
                'title' => 'There is action need your attention',
                'body' => $request->description
            ];

            Mail::to($user_row->email)->send(new SendEmail($MailData));


            return redirect()->route('cashout.admin_index')->with('success',' Comment sent Successfully!'.$request->cashout_id);

        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function edit(Cashout $cashout)
    {
        $Currency = Currency::all();
        return view('cashout.edit')->with([
            'currencies' => $Currency,
            'cashout'  => $cashout
        ]);
    }

    public function export()
    {
        return Excel::download(new CashoutExport, 'Cashout_report.xlsx');
    }

    public function update(Request $request,Cashout $cashout)
    {


        DB::beginTransaction();
        try {
            $request->validate([
                'amount'       => 'required|numeric',
                'payment' => 'required',
                'currency'     => 'required',
                'details'    => 'required',

            ]);

            Cashout::whereId($cashout->id)->update(['amount' => $request->amount,'method'   => $request->payment,'currency'  => $request->currency,'details'  => $request->details,'status'=>"Requested",]);


            // Commit And Redirected To Listing
            DB::commit();

            $cashouts = Cashout::where('receiver_id',Auth::user()->id)->paginate(10);
            return view('cashout.index', ['cashouts' => $cashouts,'success','User Created Successfully.']);

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }



}

