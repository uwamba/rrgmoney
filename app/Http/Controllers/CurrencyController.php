<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:currency-list|currency-create|currency-edit|currency-delete', ['only' => ['index']]);
        $this->middleware('permission:currency-create', ['only' => ['create','store']]);
        $this->middleware('permission:currency-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:currency-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::paginate(10);

        return view('currency.index', [
            'currencies' => $currencies
        ]);
    }

    public function currencySearch(Request $request)
    {

        $q = $request->input('query');

        $query = Currency::query()
            ->latest()
            ->select(['id', 'currency_name', 'currency_buying_rate', 'currency_selling_rate', 'currency_reference', 'currency_country','pricing_plan','charges_percentage','created_at','updated_at'])
            ->where(function (Builder $subQuery) use ($q) {
                $subQuery->where('currency_name', 'like', '%'.$q.'%')
                    ->orWhere('currency_country', 'like', '%'.$q.'%');
            })->paginate(10);

            return view('currency.index', [
                'currencies' => $currencies
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('currency.add');
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
                'currency_name' => 'required|unique:currencies|max:200',
                'currency_buying_rate' => 'required',
                'currency_selling_rate' => 'required',
                'currency_reference' => 'required',
                'pricing_plan' => 'required',
                'charges_percentage' => 'required',
            ]);

            currency::create($request->all());

            DB::commit();
            return redirect()->route('currency.index')->with('success',' created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('currency.create')->with('error',$th->getMessage());
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

        return view('currency.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function changeRate(Request $currency)
     {
        //$currencies = DB::table('currencies')->get();
        $buying = DB::table('currencies')->where('id','=',$currency->get('currency'))->first()->currency_buying_rate ?? "null";
        $selling = DB::table('currencies')->where('id','=',$currency->get('currency'))->first()->currency_selling_rate ?? "null";
        $charges= DB::table('currencies')->where('id','=',$currency->get('currency'))->first()->charges_percentage ?? "null";
        return view('currency.editRate', [
            'buying' => $buying,'charges' => $charges,'selling' => $selling,'id'=>$currency->get('currency')
        ]);

     }
     public function updateRate(Request $request)

     {

      Currency::where('id',$request->id)->update(['currency_buying_rate' => $request->currency_buying_rate,'currency_selling_rate'=>$request->currency_selling_rate,'charges_percentage'=>$request->charges]);
      return redirect()->route('currency.index')->with('success','Exchange Rate updated successfully.');
     }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            // Validate Request
            $request->validate([
                'currency_name' => 'required',
                'currency_rate_buying' => 'required',
                'currency_rate_selling' => 'required',
                'currency_reference' => 'required',
            ]);

            $county = Country::whereId($id)->first();

            $county->save();

            // Sync Permissions
            DB::commit();
            return redirect()->route('currency.index')->with('success','Roles updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('currency.edit',['role' => $role])->with('error',$th->getMessage());
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

            Currency::whereId($id)->delete();

            DB::commit();
            return redirect()->route('currency.index')->with('success','deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('currency.index')->with('error',$th->getMessage());
        }
    }
}
