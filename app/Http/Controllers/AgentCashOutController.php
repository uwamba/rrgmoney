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

      $cashout = AgentCashOut::join('users', 'users.id', '=', 'agent_cash_out.user_id')->select('agent_cash_out.status as status','agent_cash_out.created_at','agent_cash_out.amount','agent_cash_out.user_id','agent_cash_out.id as id','users.first_name','users.last_name','users.email','users.mobile_number')->orderBy('id','DESC')->paginate(10);

       return view('agent.agentCashOut.admin_index', ['cashouts' => $cashout]);
    }

 public function check_balance(Request $request)
    {
        $user_id = $request->get('user_id');
        $balance = Topup::where('user_id',$user_id)->orderBy('sequence_number', 'desc')->first()->balance_after ?? 0;
        //$balance = Topup::where('user_id',$user_id)->orderBy('id', 'desc')->first()->balance_after ?? 0;
        $balance=number_format( $balance);

        return json_encode(array('balance'=>$balance));

        //return response()->json($user);

    }

    public function create()
    {
        return view('agent.agentCashOut.add');
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
            AgentCashOut::where('status', 'Requested')->where('user_id', '=', Auth::user()->id)->delete();
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
                //$balance = Topup::where('user_id',$request->user_id)->orderBy('id', 'desc')->first()->balance_after ?? 0;
                $balance = Topup::where('user_id',$request->user_id)->orderBy('sequence_number', 'desc')->first()->balance_after ?? 0;
                //$sqs_num=Topup::find($topup->topup_id)->sequence_number;
                $sqs_num=Topup::orderBy('sequence_number', 'desc')->first()->sequence_number;
                $topup = Topup::create([
                               'amount'    => $request->amount,
                               'payment_type'   => "Cash out",
                               'sequence_number'   => $sqs_num+1,
                               'currency'  => $currency,
                               'status'  => "Approved",
                               'reference' => $request->user_id,
                               'user_id' => $request->user_id,
                               'balance_before' => $balance,
                               'balance_after_temp' => $balance-$request->amount,
                               'balance_after' => $balance-$request->amount,
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
