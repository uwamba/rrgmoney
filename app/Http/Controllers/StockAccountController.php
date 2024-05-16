<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use App\Services\StockAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAccountController extends Controller
{

    protected $accountService;

    public function __construct(StockAccountService $accountService)
    {
        $this->middleware('auth');
        $this->middleware('permission:stocKAccount-list|stocKAccount-create|stocKAccount-edit|stocKAccount-delete', ['only' => ['index']]);
        $this->middleware('permission:stocKAccount-create', ['only' => ['create','store']]);
        $this->middleware('permission:stocKAccount-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:stocKAccount-delete', ['only' => ['destroy']]);
        $this->accountService = $accountService;

    }

    public function index()
    {
        $accountList = $this->accountService->getAccountList();
        return view('StockAccount.index',['accounts'=>$accountList]);
    }
    public function create()
    {
        $countries = Country::all();
        $currencies = Currency::all();
        return view('StockAccount.add',['countries'=>$countries,'currencies'=>$currencies]);
    }
    public function setDefault(Request $request)
        {
            $id=$request->id;
            $result = $this->accountService->setDefaultAccount($id);
            if($result["msg"]=="created"){
                // dd($result["desc"]);
                return redirect()->route('StockAccount.index', ['created'=>'successfuly created']);
             }else{
                 //dd('not created');
                 return redirect()->back()->with('error', $th->getMessage());
             }


        }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' =>'required',
            'currency' => 'required',
        ]);
        $data=[
            'name' => $request->name,
            'description' =>$request->description,
            'currency' => $request->currency,
            'created_by' => auth::user()->id,
            'modified_by' => auth::user()->id,
        ];

        $result = $this->accountService->saveStockAccount($data);
        if($result["msg"]=="created"){
           // dd($result["desc"]);
           return redirect()->route('StockAccount.index', ['created'=>'successfuly created']);
        }else{
            //dd('not created');
            return redirect()->back()->with('error', $result["desc"]);
        }





    }



    //
}
