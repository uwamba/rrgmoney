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


    /**
     * List User 
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function index()
    {
        $stocks = Stock::where('user_id',Auth::user()->id)->paginate(10);
        return view('stock.index', ['stocks' => $stocks]);
    }

    public function admin_index()
    {

        $stocks = Stock::orderBy('id','DESC')->paginate(10);
       // dd( $topups);
       // $user=User::where('id', $topups->user_id)->get();
        return view('Stock.index', ['stocks' => $stocks]);
    }
    
    
    public function create()
    {
       // $stocks = Stock::all();
       
        return view('stock.add');
    }

    /**
     * Store User
     * @param Request $request
     * @return View Users
     * @author Shani Singh
     */
    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'amount'    => 'required',
            'currency'     => 'required',
        ]);

        DB::beginTransaction();
        try {
            //get balance
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
                'currency'    => $request->currency,
                'user_id'     => Auth::user()->id,
                'status'        => "Requested",
    
            ]);
            
            DB::commit();
            $stocks = Stock::where('user_id',Auth::user()->id)->paginate(10);
           return view('stock.index', ['stocks' => $stocks,'success','Stock requested Successfully.']);

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error',$th->getMessage());
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

            //available company equity
            $equity = Income::orderBy('id','Desc')->first()->balance_after ?? 0;
            

            // get user amount and current balance
        
            $amount = Stock::where('id',$request->id)->first()->amount;
            $currency = Stock::where('id',$request->id)->first()->currency;
            //check if there is enouph money to distribute
            if($equity < $amount){
                return redirect()->route('stock.admin_index')->with('error','there is no enouph money!');
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
    /**
     * Edit User
     * @param Integer $user
     * @return Collection $user
     * @author Shani Singh
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit')->with([
            'roles' => $roles,
            'user'  => $user
        ]);
    }

    /**
     * Update User
     * @param Request $request, User $user
     * @return View Users
     * @author Shani Singh
     */
    public function update(Request $request, User $user)
    {
        // Validations
        $request->validate([
                'first_name'    => $request->name,
                'last_name'     => $request->name,
                'email'         => $request->email,
                'role_id'       => $request->role_id,
                'status'        => $request->status,
        ]);

        DB::beginTransaction();
        try {

            // Store Data
            $user_updated = User::whereId($user->id)->update([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'mobile_number' => $request->mobile_number,
                'address'       => $request->address,
                'country'       => $request->country,
                'role_id'       => $request->role_id,
                'status'        => $request->status,
            ]);

            // Delete Any Existing Role
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            
            // Assign Role To User
            $user->assignRole($user->role_id);

            // Commit And Redirected To Listing
            DB::commit();
            return view('users.index')->with('success','User Updated Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Delete User
     * @param User $user
     * @return Index Users
     * @author Shani Singh
     */
    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            // Delete User
            User::whereId($user->id)->delete();

            DB::commit();
            return view('users.index')->with('success', 'User Deleted Successfully!.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Import Users 
     * @param Null
     * @return View File
     */
    public function importUsers()
    {
        return view('users.import');
    }

    public function uploadUsers(Request $request)
    {
        Excel::import(new UsersImport, $request->file);
        
        return view('users.index')->with('success', 'User Imported Successfully');
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

}
