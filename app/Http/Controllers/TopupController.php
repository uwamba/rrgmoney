<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\sendEmail;
use App\Models\Topup;
use App\Models\Stock;
use App\Models\Account;
use App\Models\Income;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class TopupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:topup-list|topup-create|topup-edit|topup-delete', ['only' => ['index']]);
        $this->middleware('permission:topup-create', ['only' => ['create','store']]);
        $this->middleware('permission:topup-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:topup-delete', ['only' => ['destroy']]);

    }


    public function index()
    {

        $topups = Topup::where('user_id',Auth::user()->id)->where('amount','>', '0')->orderBy('id','DESC')->paginate(10);
        return view('customer.topup.index', ['topups' => $topups]);
    }

    public function admin_index()
    {

        $topups = Topup::orderBy('topups.id','DESC')->join('users', 'users.id', '=', 'topups.user_id')->select('topups.status as topUpStatus','topups.payment_type','topups.id','topups.amount' ,'topups.currency','topups.created_at','users.mobile_number','users.email','users.first_name','users.last_name')->paginate(10);
       // dd( $topups);
       // $user=User::where('id', $topups->user_id)->get();
        return view('topup.index', ['topups' => $topups]);
    }
    public function find(Request $request)
    {
        $query = $request->get('type');
        $user=Account::where('type', $query)->where('country', Auth::User()->country)->get();


        return json_encode(array('data'=>$user));

        //return response()->json($user);

    }
    public function create()
    {
        $roles = Role::all();
         $currencies = Currency::all();

        return view('customer.topup.add', ['roles' => $roles,'currencies' => $currencies]);
    }

     public function agentTopUp()
        {
             $roles = Role::all();
             $currencies = Currency::all();

            return view('topup.find', ['roles' => $roles,'currencies' => $currencies]);
        }

        public function agentTopUpNext(Request $request)
          {
               $roles = Role::all();
               $currencies = Currency::all();
               return view('topup.add', ['roles' => $roles,'currencies' => $currencies,'user_id'=>$request->user_id]);
          }



    //store topup informtion in database table

    public function agentStore(Request $request)
    {
       $balance = Topup::where('user_id',$request->user_id)->orderBy('id', 'desc')->first()->balance_after ?? 0;
       $user_country=User::find($request->user_id)->country;
       $currency= DB::table('currencies')->where('currency_country', '=', $user_country)->first()->currency_name;
        DB::beginTransaction();
        try {
            $request->validate([
                'amount'       => 'required|numeric',
                'payment' => 'required',
                'reference'    => 'required',

            ]);
            // Store Data
            $topup = Topup::create([
                'amount'    => $request->amount,
                'payment_type'   => $request->payment,
                'currency'  => $currency,
                'sequence_number'   => 0,
                'reference' => $request->reference,
                'user_id' => $request->user_id,
                'balance_before' => $balance,
                'balance_after_temp' => $balance+$request->amount,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            $topups = Topup::where('user_id',$request->user_id)->orderBy('id','DESC')->paginate(10);
           //send email notification



            return redirect()->route('topup.admin_index')->with(['topups' => $topups,'success'=>'Top up  Successfully.']);


        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

     public function store(Request $request)
        {

           $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after ?? 0;
          //check if there was previous record that have


           $currency= DB::table('currencies')
           ->where('currency_country', '=', Auth::user()->country)
           ->first()->currency_name;


            DB::beginTransaction();
            try {
                $request->validate([
                    'amount'       => 'required|numeric',
                    'payment' => 'required',
                    'reference'    => 'required',

                ]);
                // Store Data
                $topup = Topup::create([
                    'amount'    => $request->amount,
                    'payment_type'   => $request->payment,
                    'currency'  => $currency,
                    'reference' => $request->reference,
                    'user_id' => $request->user_id,
                    'balance_before' => $balance,
                    'balance_after_temp' => $balance+$request->amount,
                ]);

                // Commit And Redirected To Listing
                DB::commit();
                $topups = Topup::where('user_id',Auth::user()->id)->where('status','pending')->orderBy('id','DESC')->paginate(10);
               //send email notification



                return redirect()->route('topup.index')->with(['topups' => $topups,'success'=>'Top up  Successfully.']);


            } catch (\Throwable $th) {
                // Rollback and return with Error
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', $th->getMessage());
            }
        }

    public function updateStatus(Request $request)
    {


        try {
            DB::beginTransaction();
            //update agent stock
             $stock_balance = Stock::orderBy('id','Desc')->where('balance_before', '!=' , 0)->first()->balance_before ?? 0;
             $total=$stock_balance-$request->amount;
             $user = Stock::create([
                             'amount'    => $request->amount,
                             'amount_deposit'    => 0,
                             'currency'    => $request->currency,
                             'entry_type'    => "Debit",
                             'description'    => "Stock movement",
                             'balance_before'    => $stock_balance,
                             'balance_after'    => $total,
                             'given_amount'    => $request->amount,
                             'admin_id'    => 0,
                             'status'        => "Approved_".$request->id,
                             'user_id'     => Auth::user()->id,

                         ]);

            //get stock balance
            $stock = Stock::where('user_id',Auth::user()->id)->where('currency',$request->currency)->orderBy('id','Desc')->first()->balance_after ?? 0;
             if($stock<$request->amount){
             return redirect()->back()->with('error', 'you do not have stock '.$stock.' '.$request->currency);
             }

            // get user amount and current balance
             $balance = Topup::where('id',$request->id)->orderBy('id', 'desc')->first()->balance_after ?? 0;
             //get user_id
             $user_id = Topup::where('id',$request->id)->orderBy('id', 'desc')->first()->user_id;
             //get email
            $email = User::where('id',$user_id)->orderBy('id', 'desc')->first()->email;
            //update amount and status
            Topup::whereId($request->id)->update(['status' => $request->status, 'balance_after'=>DB::raw("`balance_after_temp`"),'Agent'=>Auth::user()->id]);

            // Commit And Redirect on index with Success Message
            DB::commit();
             $details = [
                          'title' => 'Top up',
                          'body' => 'Your account top up amount '.$request->amount.' your balance is '.$balance+$request->amount
                       ];
                       Mail::to($email)->send(new sendEmail($details));
            return redirect()->route('topup.admin_index')->with('success','topup Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



}
