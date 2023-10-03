<?php

namespace App\Repository\Eloquent;

use Adldap\Query\Collection;
use App\Models\Backend\Biller;
use App\Models\Backend\BillerCategory;
use App\Models\Backend\BillerFee;
use App\Repository\BillerRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Psr\Log\LogLevel;

class BillerRepository extends BaseRepository implements BillerRepositoryInterface
{
    public function __construct(BillerCategory $model)
    {
        parent::__construct($model);
    }

    public function findBiller($id)
    {
        return Biller::find($id);
    }

    public function storeProvider(array $details)
    {
        $biller = Biller::create($details);
        BillerFee::create([
            'biller_id' => $biller->biller_code,
            'fee' => $biller->convenience_fee,
        ]);
        return $biller;
    }




}
