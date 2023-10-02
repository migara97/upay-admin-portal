<?php

namespace App\Repository;

interface JustpayBankRepositoryInterface
{
    public function getModel();
    public function getActiveBanks();
}