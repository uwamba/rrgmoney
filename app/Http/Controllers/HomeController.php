<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Topup;
use App\Models\Send;
use App\Models\Stock;
use App\Models\Cashout;
use App\Models\Account;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Collection;

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
        $bal=0;
        $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after ?? $bal;
        $last_topup = Topup::where('user_id',Auth::user()->id)->where('status','Pending')->orderBy('id', 'desc')->first()->amount ?? 0;
        $pending_request = Topup::where('user_id',Auth::user()->id)->where('status','Pending')->count();
        $received_amount = Send::where('receiver_id',Auth::user()->id)->orderBy('id', 'desc')->first()->amount_foregn_currency ?? 0;
        $sent_amount = Send::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->amount_local_currency ?? 0;



            if(Auth::user()->hasPermissionTo('dashboard-admin')){
                $user=Auth::user()->id;
                $accounts=DB::select(DB::raw("select   distinct(account_name),account_name  from stocks where user_id=:user"),array('user'=>$user));
                //$accounts = Stock::where('user_id',$user)->distinct('account_name')->get();
                //$all_accounts=array();
                $all_accounts = new Collection();
                foreach ($accounts as $account){


                    $balance=Stock::where('account_name',$account->account_name )->orderBy('sequence_number','desc')->first()->balance_after ?? 0;
                    $all_accounts->push([ $account->account_name,$balance]);

                }
             //dd($all_accounts);
              //dd($accounts);

                $account_balances=DB::select(DB::raw("select   distinct(account_name), balance_after,user_id  from stocks where balance_after=(select balance_after from stocks as st2 where st2.account_name=stocks.account_name order by st2.sequence_number desc limit 1) AND stocks.user_id=:user"),array('user'=>$user));
                $users = User::all()->count();
                $stock_balance = Stock::where('user_id',Auth::user()->id)->orderBy('sequence_number','Desc')->first()->balance_after ?? 0;
                $topups_day = Topup::whereDay('created_at', '=', date('d'))->get();
                $topups_month = Topup::whereMonth('created_at', '=', date('m'))->get();

                $amount_day=$topups_day->sum('amount');
                $amount_month=$topups_month->sum('amount');

                $charges_day=$topups_day->sum('charges');
                $charges_month=$topups_month->sum('charges');

                $sent_day = Send::whereDay('created_at', '=', date('d'))->get();
                $sent_month = Send::whereMonth('created_at', '=', date('m'))->get();

                $sent_amount_day=$sent_day->sum('amount_local_currency');
                $sent_amount_month=$sent_month->sum('amount_local_currency');

                return view('home_admin')->with(['email' =>
                Auth::user()->email,'users'=>$users,'amount_day'=> $amount_day,'amount_month'=>$amount_month,'sent_amount_day'=>$sent_amount_day,'sent_amount_month'=>$sent_amount_month,'charges_month'=>$charges_month,'charges_day'=>$charges_month,'account_balances'=>$all_accounts]);


            }
            else if (Auth::user()->hasPermissionTo('dashboard-user')){

                $accounts = Account::where('country',Auth::user()->country)->get();
                return view('customer.index')->with(['email' =>
                Auth::user()->email,'balance'=>$balance,'last_topup'=> $last_topup,'pending_request'=>$pending_request,'received_amount'=>$received_amount,'sent_amount'=>$sent_amount,'accounts'=>$accounts]);

            }
            else if (Auth::user()->hasPermissionTo('dashboard-finance')){

                $account_balances=DB::select(DB::raw("select   distinct(account_name), balance_after,user_id  from incomes where balance_after=(select balance_after from incomes as st2 where st2.account_name=incomes.account_name order by st2.id desc limit 1)"));

                  $users = User::all()->count();
                  $topups_day = Topup::whereDay('created_at', '=', date('d'))->get();
                  $topupAmount = Topup::where('user_id', '=', 0)->get();
                  $earning = Topup::where('user_id',0)->orderBy('id', 'desc')->first()->balance_after ?? 0;

                  $amount_day=$topups_day->sum('amount');
                  $charges_day=$topups_day->sum('charges');


                  $sent_day = Send::whereDay('created_at', '=', date('d'))->get();
                  $sent_month = Send::whereMonth('created_at', '=', date('m'))->get();

                  $sent_amount_day=$sent_day->sum('amount_local_currency');
                  $sent_amount_month=$sent_month->sum('amount_local_currency');

                  return view('home_finance')->with(['email' =>
                  Auth::user()->email,'users'=>$users,'amount_day'=> $amount_day,'sent_amount_day'=>$sent_amount_day,'sent_amount_month'=>$sent_amount_month,'earning'=>$earning,'account_balances'=>$account_balances]);

                        }
                else if(Auth::user()->hasPermissionTo('dashboard-agent')){
                $users = User::all()->count();
                $lastCashout = Cashout::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->amount ?? 0;
                $lastSent = Send::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->amount_local_currency ?? 0;
                $commission = Topup::where('user_id',Auth::user()->id)->orderBy('sequence_number', 'desc')->first()->balance_after ?? 0;
                //$balance = DB::table('stocks')->where('user_id',Auth::user()->id)->where('status','Approved')->orderBy('id', 'desc')->first()->balance_after ?? 0;
                $balance = DB::table('stocks')->where('user_id',Auth::user()->id)
                ->where(function ($query) {
                   $query->where('status','Approved')
                   ->orWhere('status','auto-approved');
                })
                 ->orderBy('sequence_number', 'desc')->first()->balance_after ?? 0;
                return view('agent.index')->with(['email' =>
                Auth::user()->email,'balance'=>$balance,'lastSent'=>$lastSent,'commission'=>$commission,'users'=>$users]);
            }
            else{

                return view('home_no_content');
            }


    }


    public function getProfile()
    {
        return view('profile');
    }

    /**
     * Update Profile
     * @param $profileData
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function updateProfile(Request $request)
    {
        #Validations
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'mobile_number' => 'required|numeric|digits:10',
        ]);

        try {
            DB::beginTransaction();

            #Update Profile Data
            User::whereId(auth()->user()->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
            ]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Profile Updated Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Change Password
     * @param Old Password, New Password, Confirm New Password
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        try {
            DB::beginTransaction();

            #Update Password
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Password Changed Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}
