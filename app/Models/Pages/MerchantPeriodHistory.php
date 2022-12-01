<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantPeriodHistory extends Model
{
    use HasFactory;

    protected $table = 'merchant_period_histories';

    protected $guarded = [];

    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }
}
