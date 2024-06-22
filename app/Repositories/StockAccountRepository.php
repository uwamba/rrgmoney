<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use App\Models\StockAccount;
use App\Interfaces\StockAccountInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StockAccountRepository{




    public function create(Array $data){

           try {
            $created=Send::create($data);
            return ['msg'=>'created','desc'=>'successfuly created'];

           } catch(\Illuminate\Database\QueryException $ex){
            return ['msg'=>'error','desc'=>$ex->getMessage()];

          }


        return $created;
    }



}
