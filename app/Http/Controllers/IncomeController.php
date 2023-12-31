<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Topup;
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
    public function income()
    {
       $topup = Topup::where('user_id',0)->orderBy('id','DESC')->paginate(10);
        return view('capital.income', ['topup' => $topup]);
    }
    public function reset()
        {
         DB::beginTransaction();
        $balance = Topup::where('user_id',0)->orderBy('id', 'desc')->first()->balance_after ?? 0;
        $topup = Topup::create([
                            'amount'    => 0,
                            'payment_type'   => 'reset',
                            'currency'  => 'null',
                            'reference' => 'null',
                            'user_id' => 0,
                            'balance_before' => $balance,
                            'balance_after_temp' => 0,
                        ]);
       DB::commit();
       $topup = Topup::where('user_id',0)->orderBy('id','DESC')->paginate(10);

     return view('capital.income', ['success'=>'Successfully reset.','topup' => $topup]);
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

}
