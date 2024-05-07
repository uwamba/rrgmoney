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

}
