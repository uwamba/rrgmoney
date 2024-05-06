<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StockAccountService;
use Illuminate\Http\Request;

class StockAccountController extends Controller
{
    protected $stockAccount;
    protected $accountService;
    public function __construct( StockAccountService $accountService)
    {
       // $this->stockAccount = $stockAccount;
        $this->accountService = $accountService;
    }
    
    public function index()
    {
        $accountList = $this->accountService->getAccountList();
        return $accountList;
    }
    //
}
