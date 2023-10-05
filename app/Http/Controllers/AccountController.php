<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Currency;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:account-list|account-create|account-edit|account-delete', ['only' => ['index']]);
        $this->middleware('permission:account-create', ['only' => ['create','store']]);
        $this->middleware('permission:account-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:account-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::paginate(10);

        return view('account.index', [
            'accounts' => $accounts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $currencies = Currency::all();
        return view('account.add' , [
            'countries' => $currencies,
             'currencies' => $currencies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'type' => 'required',
                'name' => 'required',
                'number' => 'required',
                'country' => 'required',
                'swift_code' => 'required',
                'currency' => 'required',
            ]);
    
            account::create($request->all());

            DB::commit();
            return redirect()->route('account.index')->with('success',' created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('account.create')->with('error',$th->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = Account::whereId($id)->first();
        

        return view('account.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            // Validate Request
            $request->validate([
                'type' => 'required',
                'name' => 'required',
                'number' => 'required',
                'country' => 'required',
                'swift_code' => 'required',
                'currency' => 'required',
                'number' => 'required',
            ]);
            
            $account = Account::whereId($id)->first();

            $county->save();

            // Sync Permissions
            DB::commit();
            return redirect()->route('account.index')->with('success','Roles updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('account.edit',['role' => $role])->with('error',$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
    
            County::whereId($id)->delete();
            
            DB::commit();
            return redirect()->route('account.index')->with('success','deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('account.index')->with('error',$th->getMessage());
        }
    }
}

