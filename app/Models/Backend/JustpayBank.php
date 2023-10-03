<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JustpayBank extends Model
{
    use HasFactory;

    protected $table = "justpay_bank";
    // protected $connection = 'app_mysql';
    public $timestamps = false;

    const ACTIVE = 1;

    protected $fillable = [
        'id',
        'code',
        'icon',
        'name',
        'state',
        'cefts_bank_id'
    ];

    public function billers()
    {
        return $this->belongsToMany(Biller::class);
    }
}
