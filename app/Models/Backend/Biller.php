<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Biller extends Model
{
    use HasFactory;

    const ACTIVE = 1;

    public $timestamps = false;
    // protected $connection = 'app_mysql';
    protected $table = 'biller';
    protected $fillable = [
        'biller_code',
        'biller_name',
        'biller_order',
        'category_id',
        'convenience_fee',
        'is_mobile',
        'is_num',
        'max_length',
        'min_length',
        'provider_image',
        'state',
        'account_number',
        'bank_id',
        'max_amount',
        'min_amount',
        'label',
        'place_holder'
    ];

    public function bank(): HasOne
    {
        return $this->hasOne(JustpayBank::class,'id', 'bank_id');
    }
}
