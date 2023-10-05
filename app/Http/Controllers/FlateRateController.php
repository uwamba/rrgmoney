<?php

namespace App\Http\Controllers;
use App\Models\flate_rate;
use App\Models\currency;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FlateRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:flat_rate-list|flat_rate-create|flat_rate-edit|flat_rate-delete', ['only' => ['index']]);
        $this->middleware('permission:flat_rate-create', ['only' => ['create','store']]);
        $this->middleware('permission:flat_rate-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:flat_rate-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flat_rate = flate_rate::join('currencies', 'currencies.id', '=', 'flate_rates.currency_id')->paginate(10);

        return view('flat_rate.index', [
            'flat_rates' => $flat_rate
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $currency)
    {
       
        $flat_rate = flate_rate::join('currencies', 'currencies.id', '=', 'flate_rates.currency_id')->where('flate_rates.currency_id',$currency->currency)->paginate(10);
        return view('flat_rate.add',[
            'flat_rates' => $flat_rate,'currency'=>$currency->currency
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
                'from_amount' => 'required',
                'to_amount' => 'required',
                'charges_amount' => 'required',
                'charges_amount_percentage' => 'required',
        
            ]);
            
    
            flate_rate::create($request->all());



            DB::commit();
            return redirect()->route('flat_rate.index')->with('success',' created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('currency.index')->with('error',$th->getMessage());
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
        $country = Flate_rate::whereId($id)->first();
        

        return view('flat_rate.edit');
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
                'from' => 'required',
                'to' => 'required',
                'amount' => 'required',
            ]);
            
            $county = Flate_rate::whereId($id)->first();

            $county->save();

            // Sync Permissions
            DB::commit();
            return redirect()->route('flat_rate.index')->with('success','Roles updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('flat_rate.edit',['role' => $role])->with('error',$th->getMessage());
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
            return redirect()->route('flat_rate.index')->with('success','deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('flat_rate.index')->with('error',$th->getMessage());
        }
    }
}
