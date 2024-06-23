<?php

namespace App\Services;

use App\Interfaces\StockAccountInterface;

class StockAccountService

{
    protected $stockRepository;
    public function __construct(StockAccountInterface $stockRepository) {
        $this->stockRepository=$stockRepository;

    }


    public function getAccountList()
    {
        return $this->stockRepository->getAccountList();
    }
    public function setDefaultAccount($id)
    {
        return $this->stockRepository->setDefault($id);
    }

    public function saveStockAccount(array $data){
     return $this->stockRepository->create($data);
    }

}
