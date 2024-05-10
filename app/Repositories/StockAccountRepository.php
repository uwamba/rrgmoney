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


    public function getId(){}
    public function getName(){}
    public function getCurrencyName(){}
    public function getDescription(){}
    public function getAmount(){}
    public function getCreatedAt(){}
    public function getUpdatedAt(){}
    public function create(Array $data){

           try {
            $created=StockAccount::create($data);
            return ['msg'=>'created','desc'=>'successfuly created'];

           } catch(\Illuminate\Database\QueryException $ex){
            return ['msg'=>'error','desc'=>$ex->getMessage()];

          }


        return $created;
    }
    public function update(){}
    public function edit(){}



}
