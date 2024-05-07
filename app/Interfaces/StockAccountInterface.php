<?php

namespace App\Interfaces;

interface StockAccountInterface {

    public function getAccountList();
    public function getId();
    public function getName();
    public function getCurrencyName();
    public function getDescription();
    public function getAmount();
    public function getCreatedAt();
    public function getUpdatedAt();
    public function create();
    public function update();
    public function edit();

}
