<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantTerminal extends Model
{
    use HasFactory;

    protected $table = "merchant_terminals";

    protected $guarded = [];

    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }
}
