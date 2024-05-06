<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use App\Models\StockAccount;
use App\Interfaces\StockAccountInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

 
class StockAccountRepository implements StockAccountInterface{

    public function getAccountList()
    {
        $accountList=StockAccount::all();
        return  $accountList;

    }

 
   
}