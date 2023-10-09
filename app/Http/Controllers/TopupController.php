<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Topup;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


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

    /**
     * List topup
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function index()
    {

        $topups = Topup::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);

       // dd( $topups);
       // $user=User::where('id', $topups->user_id)->get();
        return view('customer.topup.index', ['topups' => $topups]);
    }
    public function admin_index()
    {

        $topups = Topup::orderBy('id','DESC')->paginate(10);
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

    //store topup informtion in database table

    public function store(Request $request)
    {
        //dd('validations');
        // Validations

       // dd('validations');
       $balance = Topup::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first()->balance_after;
       $currency= DB::table('currencies')
       ->where('currency_country', '=', Auth::user()->country)
       ->first()->currency_name;
       if(!$currency==$request->currency){
           return redirect()->back()->withInput()->with('error', "you can't top with defferenct currency");
       }
        //$balance=Topup::latest()->first()->balance_after;
        //dd($balance);

        DB::beginTransaction();
        try {
            $request->validate([
                'amount'       => 'required|numeric',
                'payment' => 'required',
                'currency'     => 'required',
                'reference'    => 'required',

            ]);

            // Store Data
            $topup = Topup::create([
                'amount'    => $request->amount,
                'payment_type'   => $request->payment,
                'currency'  => $request->currency,
                'reference' => $request->reference,
                'user_id' => auth::user()->id,
                'balance_before' => $balance,
                'balance_after' => $balance+$request->amount,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            $topups = Topup::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
           //send email notification
           $details = [
              'title' => 'Mail from ItSolutionStuff.com',
              'body' => 'This is for testing email using smtp'
           ];
           Mail::to('uwambadodo@gmail.com')->send(new \App\Mail\sendEmail($details));



            return view('customer.topup.index', ['topups' => $topups,'success','User Created Successfully.']);

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


            //update amount and status
            Topup::whereId($request->id)->update(['status' => $request->status,'Agent'=>Auth::user()->id]);

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
