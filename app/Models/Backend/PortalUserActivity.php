<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalUserActivity extends Model
{
    use HasFactory;
    
    protected $table = "activities";

    protected $fillable = [
        "user",
        "affected_app_user",
        "reference",
        "action",
        "description",
    ];
}
