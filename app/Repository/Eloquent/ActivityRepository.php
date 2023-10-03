<?php

namespace App\Repository\Eloquent;

use App\Models\Backend\PortalUserActivity;
use App\Repository\ActivityRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class ActivityRepository extends BaseRepository implements ActivityRepositoryInterface {
    #[Pure] public function __construct(PortalUserActivity $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function saveActivity(array $activity): Model|Builder
    {
        return $this->model->query()->create(json_decode(json_encode($activity), true));
    }
}
