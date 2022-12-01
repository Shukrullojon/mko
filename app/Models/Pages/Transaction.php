<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $guarded = [];

    public function account(){
        return $this->belongsTo(Account::class);
    }

    public function payment(){
        return $this->belongsTo(Payment::class);
    }
}
