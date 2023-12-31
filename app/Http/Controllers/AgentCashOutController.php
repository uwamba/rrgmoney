<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AgentCashOut;
use App\Models\Stock;
use App\Models\Topup;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class AgentCashOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:AgentCashOut-list|AgentCashOut-create|AgentCashOut-edit|AgentCashOut-delete', ['only' => ['index']]);
        $this->middleware('permission:AgentCashOut-create', ['only' => ['create','store']]);
        $this->middleware('permission:AgentCashOut-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:AgentCashOut-delete', ['only' => ['destroy']]);

    }



    public function index()
    {
        $cashout = AgentCashOut::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
        return view('agent.agentCashOut.index', ['stocks' => $cashout]);
    }


    public function admin_index()
    {

      $cashout = AgentCashOut::orderBy('id','DESC')->paginate(10);

       return view('agent.agentCashOut.admin_index', ['cashouts' => $cashout]);
    }

 public function check_balance(Request $request)
    {
        $user_id = $request->get('user_id');
        $balance = Topup::where('user_id',$user_id)->orderBy('id', 'desc')->first()->balance_after ?? 0;
        $balance=number_format( $balance);

        return json_encode(array('balance'=>$balance));

        //return response()->json($user);

    }

    public function create()
    {
        return view('agent.AgentCashOut.add');
    }


    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'amount'    => 'required',
        ]);

        DB::beginTransaction();
        try {
            //delete request which not approved
            Stock::where('status', 'Requested')->delete();
            //get balance
            $currency= DB::table('currencies')->where('currency_country', '=', Auth::user()->country)->first()->currency_name;
            $balance=0;

            // Store Data
            $user = AgentCashOut::Create([
                'amount'    => $request->amount,
                'method'    => "not specified",
                'user_id'     => Auth::user()->id,
                'admin_id'     => 0,
                'status'        => "Requested",

            ]);

            DB::commit();
            return redirect()->route('AgentCashOut.index')->with(['success','Stock requested Successfully.']);

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
                //get currency of user
                $user_country=User::find($request->user_id)->country;
                $currency= DB::table('currencies')->where('currency_country', '=', $user_country)->first()->currency_name;
                $balance = Topup::where('user_id',$request->user_id)->orderBy('id', 'desc')->first()->balance_after ?? 0;

               $topup = Topup::create([
                               'amount'    => $request->amount,
                               'payment_type'   => "Cash out",
                               'currency'  => $currency,
                               'reference' => $request->user_id,
                               'user_id' => $request->user_id,
                               'balance_before' => $balance,
                               'balance_after_temp' => $balance-$request->amount,
                           ]);


                AgentCashOut::whereId($request->id)->update(['status' => $request->status,'admin_id'=>Auth::user()->id]);

                // Commit And Redirect on index with Success Message
                DB::commit();
                return redirect()->route('AgentCashOut.admin_index')->with('success','Status Updated Successfully!');
            } catch (\Throwable $th) {

                // Rollback & Return Error Message
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }
        }









}
