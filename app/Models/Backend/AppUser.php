<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    use HasFactory;

    // protected $connection = 'app_mysql';
    protected $table = 'app_user';
    public $timestamps = false;

    protected $fillable = [
        'status',
        'nic',
        'phone_number',
        'nic_back',
        'nic_front',
        'app_user_group_id'
    ];
}
