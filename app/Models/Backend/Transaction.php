<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transaction";
//    protected $connection = 'app_mysql';
    public $timestamps = false;

    const SUCCESS = "SUCCESS";
    const FAILED = "FAILED";
    const PENDING = "PENDING";
    const INCOMPLETE = "INCOMPLETE";
    const REFUNDED = "REFUNDED";

    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(AppUser::class, 'payer_id', 'username');
    }
}
