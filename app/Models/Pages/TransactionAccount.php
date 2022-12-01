<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionAccount extends Model
{
    use HasFactory;

    protected $table = 'transaction_accounts';

    protected $guarded = [];

    public function sender(){
        return $this->belongsTo(Account::class);
    }

    public function receiver(){
        return $this->belongsTo(Account::class);
    }


}
