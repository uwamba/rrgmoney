<?php

namespace App\Services;

use App\Interfaces\StockAccountInterface;

class StockAccountService

{
    protected $userRepository;
    public function __construct(StockAccountInterface $userRepository) {
        $this->userRepository=$userRepository;

    }


    public function getAccountList()
    {
        return $this->userRepository->getAccountList();
    }
    public function setDefaultAccount($id)
    {
        return $this->userRepository->setDefault($id);
    }

    public function saveStockAccount(array $data){
     return $this->userRepository->create($data);
    }

}
