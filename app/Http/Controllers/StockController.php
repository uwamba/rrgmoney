<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:stock-list|stock-create|stock-edit|stock-delete', ['only' => ['index']]);
        $this->middleware('permission:stock-create', ['only' => ['create','store']]);
        $this->middleware('permission:stock-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:stock-delete', ['only' => ['destroy']]);

    }



    public function index()
    {
        $stocks = Stock::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
        return view('agent.stock.index', ['stocks' => $stocks]);
    }

    public function admin_index()
    {

        $stocks = Stock::orderBy('id','DESC')->join('users', 'users.id', '=', 'stocks.user_id')->where('users.role',5)->paginate(10);
       // dd( $topups);
       // $user=User::where('id', $topups->user_id)->get();
        return view('stock.index', ['stocks' => $stocks]);
    }
    public function financeApproval()
        {

            $stocks = Stock::orderBy('id','DESC')->join('users', 'users.id', '=', 'stocks.user_id')->where('users.role_id',1)->paginate(10);
           // dd( $topups);
           // $user=User::where('id', $topups->user_id)->get();
            return view('stock.index', ['stocks' => $stocks]);
        }


    public function create()
    {
     $currency= DB::table('currencies')->where('currency_country', '=', Auth::user()->country)->first()->currency_name;
        return view('agent.stock.add',['currency' => $currency]);
    }


    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'amount'    => 'required',
        ]);

        DB::beginTransaction();
        try {
            //get balance
            $currency= DB::table('currencies')->where('currency_country', '=', Auth::user()->country)->first()->currency_name;
            $balance=0;
            $row = Stock::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first();
           if(!$row){
            $balance=0;
           }else{
            $balance= $row->balance_after;
           }

            // Store Data
            $user = Stock::create([
                'amount'    => $request->amount,
                'amount_deposit'    => 0,
                'admin_id'    => 0,
                'balance_before'    => $balance,
                'balance_after'    => 0,
                'given_amount'    => 0,
                'currency'    => $currency,
                'user_id'     => Auth::user()->id,
                'status'        => "Requested",

            ]);

            DB::commit();
            $stocks = Stock::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
            return redirect()->route('stock.index')->with(['stocks' => $stocks,'success','Stock requested Successfully.']);

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error','error in saving!! try again');
        }
    }

    /**
     * Update Status Of User
     * @param Integer $status
     * @return List Page With Success
     * @author Shani Singh
     */
    public function updateStatus(Request $request)
    {


        // If Validations Fails


        try {
            DB::beginTransaction();
            //get currency of user
            $currency = Stock::where('id',$request->id)->first()->currency;
            //available company equity
            $equity = Income::where('currency',$currency)->orderBy('id','Desc')->first()->balance_after ?? 0;


            // get user amount and current balance

            $amount = Stock::where('id',$request->id)->where('currency',$currency)->first()->amount ?? 0;

            //check if there is enouph money to distribute
            if($equity < $amount){
                return redirect()->route('stock.admin_index')->with('error','there is no enouph money in '.$currency);
            }

            $user = Income::create([
                'amount'    => $amount,
                'currency'    => $request->currency,
                'entry_type'    => "Credit",
                'description'    => "Stock movement",
                'balance_before'    => $equity,
                'balance_after'    => $equity-$amount,
                'given_amount'    => $amount,
                'currency'    =>  $currency,
                'user_id'     => Auth::user()->id,

            ]);

            $stock_balance = Stock::orderBy('id','Desc')->first()->balance_before ?? 0;
            $total=$stock_balance+$amount;
            //dd($total);
            //update amount and status
            Stock::whereId($request->id)->update(['status' => $request->status."(".$request->id.")",'balance_after'=>$total,'admin_id'=>Auth::user()->id]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('stock.admin_index')->with('success','Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }









}
