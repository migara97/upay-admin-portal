<?php

namespace App\Repository\Eloquent;

use App\Models\Backend\FormDualAuth;
use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function all(): Model
    {
        return $this->model->all();
    }

//    public function store(FormDualAuth $dualAuth)
//    {
//        return $dualAuth;
//    }
}
