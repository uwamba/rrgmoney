<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use App\Services\StockAccountService;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $date=$request->validate([
            'name' => 'required',
            'description' =>'required',
            'currency' => 'required',
            'created_by' => 'required',
            'modified_by' => 'required',
        ]);
        $account = $this->accountService->create($data);

        return redirect()->route('StockAccount.index', ['created'=>'successfuly created']);

        return $this->saveStockAccount($request);
    }



    //
}
