<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class IncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:income-list|income-create|income-edit|income-delete', ['only' => ['index']]);
        $this->middleware('permission:income-create', ['only' => ['create','store']]);
        $this->middleware('permission:income-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:income-delete', ['only' => ['destroy']]);

    }



    public function index()
    {
       $income = Income::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
        return view('capital.index', ['income' => $income]);
    }

    public function admin_index()
    {

        return view('capital.add');
    }


    public function create()
    {
    return view('capital.add');
    }


    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'amount'    => 'required',
            'description'    => 'required',
        ]);

        DB::beginTransaction();
        try {
        //currency
        $currency= DB::table('currencies')->where('currency_country', '=', Auth::user()->country)->first()->currency_name;
        //balance
        $balance = income::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after ?? 0;


        //store in database
            $user = Income::create([
                'amount'    => $request->amount,
                'entry_type'    => "debit",
                'description'    => $request->amount,
                'balance_before'    => $balance,
                'balance_after'    => $request->amount+$balance,
                'currency'    => $currency,
                'user_id'     => Auth::user()->id,


            ]);

            DB::commit();

            return redirect()->route('income.index')->with(['success','Successfully Created.']);

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
