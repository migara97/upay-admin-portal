<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $table = "parameter";
    // protected $connection = 'app_mysql';
    public $timestamps = false;

    protected $fillable = [
        'value'
    ];

    const PIN = "PIN_VALIDITY_PERIOD";
    const SYSTEM_CONFIG = "SYSTEM_SUSPEND_CONTENT";
    const PASSWORD_HISTORY = "CHECK_PASSWORD_HISTORIES";
    const APP_UNUSED_DAYS = "APP_UNUSED_DAYS";
    const REVIEW_USER = "MANUAL_USER_REVIEW";
    const PORTAL_LOGIN_ATTEMPTS = "MAX_PORTAL_LOGIN_ATTEMPTS";
    const PORTAL_PASSWORD_EXPIRES_DAYS = "PORTAL_PASSWORD_EXPIRES_DAYS";
}
