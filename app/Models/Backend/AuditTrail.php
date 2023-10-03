<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

//    protected $connection = 'app_mysql';
    protected $table = 'audit_trail';
    public $timestamps = false;

    const APP = "APP";
    const ADMIN = "ADMIN";
}
