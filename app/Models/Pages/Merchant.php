<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $table = 'merchants';

    protected $guarded = [];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function account(){
        return $this->belongsTo(Account::class);
    }
    public function terminal(){
        return $this->belongsTo(MerchantTerminal::class);
    }

    public function periods(){
        return $this->hasMany(MerchantPeriod::class)->select('id','period','percentage')->where('status',1);
    }
}
