<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Send;


class TransferStoreRepository {

    protected $model;

    public function __construct(Send $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, array $data)
    {
        $transfer = $this->model->findOrFail($id);
        $transfer->update($data);
        return $transfer;
    }
    public function create(Array $data)
    {

           try {
            $created=Send::create($data);
            return ['msg'=>'created','desc'=>'successfuly created'];

           } catch(\Illuminate\Database\QueryException $ex){
            return ['msg'=>'error','desc'=>$ex->getMessage()];

          }


        return $created;
    }




}
