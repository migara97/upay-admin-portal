<?php

namespace App\Repository\Eloquent;

use App\Models\Backend\JustpayBank;
use App\Repository\JustpayBankRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class JustpayBankRepository extends BaseRepository implements JustpayBankRepositoryInterface
{
    public function __construct(JustpayBank $model)
    {
        parent::__construct($model);
    }

    public function getModel()
    {
        return $this->model;
    }
    
    public function getActiveBanks(): Collection|array
    {
        return JustpayBank::query()->select(['id', 'name', 'icon'])->where('state', JustpayBank::ACTIVE)->get();
    }
}
