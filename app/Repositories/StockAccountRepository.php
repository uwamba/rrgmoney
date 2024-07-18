<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use App\Models\StockAccount;
use App\Interfaces\StockAccountInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


class StockAccountRepository implements StockAccountInterface{




    public function create(Array $data){

           try {
            $created=StockAccount::create($data);
            return ['msg'=>'created','desc'=>'successfuly created'];

           } catch(\Illuminate\Database\QueryException $ex){
            return ['msg'=>'error','desc'=>$ex->getMessage()];

          }


        return $created;
    }
    public function getAccountList(){
        $accounts=StockAccount::all();
        return  $accounts;
    }

    public function stockAccountSearch($query)
    {

        $q = $query;

        $stocks = StockAccount::query()
            ->latest()
            ->select(['id','stock_accounts.name','stock_accounts.created_at','stock_accounts.description','stock_accounts.currency','stock_accounts.created_by','stock_accounts.default'])
            ->where(function (Builder $subQuery) use ($q) {
                $subQuery->where('stock_accounts.name', 'like', '%'.$q.'%')
                    ->orWhere('stock_accounts.currency', 'like', '%'.$q.'%');
            })->paginate(10);

            return  $stocks;
    }



}
