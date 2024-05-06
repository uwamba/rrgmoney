<?php

namespace App\Services;

use App\Interfaces\StockAccountInterface;

class StockAccountService
{
    public function __construct(protected StockAccountInterface $userRepository) {
    }

   
    public function getAccountList()
    {
        return $this->userRepository->getAccountList();
    }
    
}