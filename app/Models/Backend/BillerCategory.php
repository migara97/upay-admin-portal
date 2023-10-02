<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillerCategory extends Model
{
    use HasFactory;

//    protected $connection = 'app_mysql';
    protected $table = 'biller_category';
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'category_order',
        'category_status',
        'category_type',
        'name',
    ];

    const ACTIVE = 1;
}
