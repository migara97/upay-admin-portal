<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillerFee extends Model
{
    use HasFactory;

    protected $table = "biller_fee";
    // protected $connection = 'app_mysql';
    public $timestamps = false;

    protected $fillable = [
        'fee',
        'biller_id'
    ];

    public function biller()
    {
        return $this->belongsTo(Biller::class, 'biller_id', 'biller_code');
    }
}
