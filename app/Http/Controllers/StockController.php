<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Income;
use App\Models\StockAccount;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


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
    public function adminList()
    {
       $stocks = Stock::join('users', 'users.id', '=', 'stocks.user_id')->where('user_id',Auth::user()->id)->select('stocks.status as status','stocks.created_at','stocks.amount','stocks.currency','stocks.balance_after','stocks.balance_before','stocks.user_id','stocks.id as id','users.first_name','users.last_name','users.email','users.mobile_number')->orderBy('id','DESC')->paginate(10);
      return view('stock.list', ['stocks' => $stocks]);
    }

    public function admin_index()
    {

        $stocks = Stock::join('users', 'users.id', '=', 'stocks.user_id')->where('users.role_id',4)->select('stocks.status as status','stocks.created_at','stocks.amount','stocks.currency','stocks.balance_after','stocks.balance_before','stocks.user_id','stocks.id as id','users.first_name','users.last_name','users.email','users.mobile_number')->orderBy('id','DESC')->paginate(10);
       // dd( $topups);
       // $user=User::where('id', $topups->user_id)->get();
        return view('stock.adminList', ['stocks' => $stocks]);
    }
    public function stockSearch(Request $request)
    {

        $q = $request->input('query');

        $sents = Stock::query()
            ->latest()
            ->join('users', 'users.id', '=', 'stocks.user_id')
            ->select(['stocks.status as status','stocks.created_at','stocks.amount','stocks.currency','stocks.balance_after','stocks.balance_before','stocks.user_id','stocks.id as id','users.first_name','users.last_name','users.email','users.mobile_number'])
            ->where(function (Builder $subQuery) use ($q) {
                $subQuery->where('users.first_name', 'like', '%'.$q.'%')
                    ->orWhere('users.email', 'like', '%'.$q.'%')
                    ->orWhere('users.mobile_number', 'like', '%'.$q.'%');
            })->paginate(10);

            return view('stock.adminList', ['stocks' => $stocks]);
    }

    public function financeApproval()
        {

          $stocks = Stock::orderBy('stocks.id','DESC')->join('users', 'users.id', '=', 'stocks.user_id')->where('users.role_id',6)->select('stocks.status as status','stocks.created_at','stocks.amount','stocks.currency','stocks.balance_after','stocks.balance_before','stocks.account_name','stocks.user_id','stocks.id as id')->paginate(10);
           // dd( $topups);
           // $user=User::where('id', $topups->user_id)->get();
            return view('stock.index', ['stocks' => $stocks]);
        }


    public function create()
    {
     $currency= DB::table('currencies')->where('currency_country', '=', Auth::user()->country)->first()->currency_name;
        return view('agent.stock.add',['currency' => $currency]);
    }
     public function adminCreate()
        {
         $account= StockAccount::all();
            return view('stock.add',['account' => $account]);
        }

        public function storeAgent(Request $request)
        {
            // Validations
            $request->validate([
                'amount'    => 'required',
            ]);

            DB::beginTransaction();

                //delete request which not approved
                //Stock::where('status', 'Requested')->delete();
                //get balance
                $defaultAccount=StockAccount::where('default',1)->first()->name ?? "null";
                if($defaultAccount=="null"){
                    return redirect()->back()->withInput()->with('error','there is no default account');
                }
                $currency=StockAccount::where('default',1)->first()->currency;
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
                    'account_name'    => $defaultAccount,
                    'amount_deposit'    => 0,
                    'admin_id'          => 0,
                    'sequence_number'   => 0,
                    'balance_before'    => $balance,
                    'balance_after'    => 0,
                    'given_amount'    => 0,
                    'currency'    => $currency,
                    'user_id'     => Auth::user()->id,
                    'status'        => "Requested",

                ]);

                DB::commit();
                $stocks = Stock::where('user_id',Auth::user()->id)->orderBy('sequence_number','DESC')->paginate(10);
                $role=Auth::user()->role_id;
                if($role==4 ){
                    return redirect()->route('stock.index')->with(['stocks' => $stocks,'success','Stock requested Successfully.']);
                }else{
                    return redirect()->route('stock.adminList')->with(['success','Stock requested Successfully.']);

                }

               //


        }
    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'amount'    => 'required',
            'account_name'    => 'required',
        ]);

        DB::beginTransaction();
        try {
            //delete request which not approved
            //Stock::where('status', 'Requested')->delete();
            //get balance
            $currency=StockAccount::where('name',$request->account_name)->first()->currency;


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
                'account_name'    => $request->account_name,
                'amount_deposit'    => 0,
                'admin_id'          => 0,
                'sequence_number'   => 0,
                'balance_before'    => $balance,
                'balance_after'    => 0,
                'given_amount'    => 0,
                'currency'    => $currency,
                'user_id'     => Auth::user()->id,
                'status'        => "Requested",

            ]);

            DB::commit();
            $stocks = Stock::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
            $role=Auth::user()->role_id;
            if($role==4 ){
                return redirect()->route('stock.index')->with(['stocks' => $stocks,'success','Stock requested Successfully.']);
            }else{
                return redirect()->route('stock.adminList')->with(['success','Stock requested Successfully.']);

            }

           //

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error','error in saving!! try again');
        }
    }



        public function updateStatus(Request $request)
        {

            try {
                DB::beginTransaction();
                //get currency of user

                $currency=StockAccount::where('default',1)->first()->currency;
                $defaultAccount=StockAccount::where('default',1)->first()->name;
                $user_id=Stock::where('id',$request->id)->first()->user_id;
                $balance = Stock::where('user_id',Auth::user()->id)
                ->where('account_name',$defaultAccount)
                ->orderBy('sequence_number','DESC')->first()->balance_after ?? 0;

                // get user amount and current balance

                $amount = Stock::where('id',$request->id)->first()->amount ?? 0;

                //check if there is enouph money to distribute
                if($balance < $amount){
                    return redirect()->back()->with('error','there is no enough money in '.$currency);
                }
               $first_name=User::find($request->user_id)->first_name;
               $last_name=User::find($request->user_id)->last_name;
               $names= $first_name." ".$last_name;
               $sqs_num=Stock::orderBy('sequence_number', 'desc')->first()->sequence_number;
               $stock = Stock::create([
                    'amount'    => $amount,
                    'account_name'=>$defaultAccount,
                    'entry_type'    => "Credit",
                    'amount_deposit'=>0,
                    'sequence_number'   => $sqs_num+1,
                    'description'    => $names,
                    'balance_before'    => $balance,
                    'balance_after'    => $balance-$amount,
                    'given_amount'    => $amount,
                    'currency'    =>  $currency,
                    'admin_id'    =>  Auth::user()->id,
                    'user_id'     => Auth::user()->id,
                    'status'     => 'auto-approved',

                ]);
                $sqs_num=Stock::orderBy('sequence_number', 'desc')->first()->sequence_number;
                $stock_balance = Stock::where('user_id',$request->user_id)->where('account_name',$defaultAccount)->orderBy('sequence_number','Desc')->first()->balance_after ?? 0;
                $total=$stock_balance+$amount;
                //update amount and status
                Stock::whereId($request->id)->update(['status' => $request->status,'balance_before'=>$stock_balance,'sequence_number'=>$sqs_num+1,'balance_after'=>$total,'admin_id'=>Auth::user()->id]);

                // Commit And Redirect on index with Success Message
                DB::commit();
                return redirect()->route('stock.admin_index')->with('success','Status Updated Successfully!');
            } catch (\Throwable $th) {

                // Rollback & Return Error Message
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }
        }
      public function FinanceUpdateStatus(Request $request)
        {

            try {
                DB::beginTransaction();
                //get currency of user

               $currency= Stock::where('id',$request->id)->first()->currency;
              // dd($request->account_name);
                $balance = income::where('user_id',Auth::user()->id)->where('account_name',$request->account_name)->orderBy('id', 'desc')->first()->balance_after ?? 0;
                // get user amount and current balance

                $amount = Stock::where('id',$request->id)->first()->amount ?? 0;

                //check if there is enouph money to distribute
                if($balance < $amount){
                    return redirect()->back()->with('error','there is no enough money on the requested account, amount: '.$amount." Balance:".$balance);
                }
               $first_name=User::find($request->user_id)->first_name;
               $last_name=User::find($request->user_id)->last_name;
               $names= $first_name." ".$last_name;

                 $income = Income::create([
                                'amount'    => $request->amount,
                                'account_name'    => $request->account_name,
                                'entry_type'    => "Credit",
                                'description'    => $request->amount,
                                'balance_before'    => $balance,
                                'balance_after'    => $balance-$request->amount,
                                'currency'    => $currency,
                                'user_id'     => Auth::user()->id,


                 ]);
                 $sqs_num=Stock::orderBy('sequence_number', 'desc')->first()->sequence_number;
                //$stock_balance = Stock::where('user_id',$request->user_id)->orderBy('id','Desc')->first()->balance_before ?? 0;
                $stock_balance = Stock::where('user_id',$request->user_id)->where('account_name',$request->account_name)->orderBy('sequence_number','Desc')->first()->balance_after ?? 0;
                $total=$stock_balance+$amount;
                //update amount and status
                Stock::whereId($request->id)->update(['status' => $request->status,'balance_before'=>$stock_balance,'balance_after'=>$total,'sequence_number'=>$sqs_num+1,'admin_id'=>Auth::user()->id]);

                // Commit And Redirect on index with Success Message
                DB::commit();
                return redirect()->route('stock.financeApproval')->with('success','Status Updated Successfully!');
            } catch (\Throwable $th) {

                // Rollback & Return Error Message
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }
        }








}
