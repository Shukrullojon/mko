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

    public function sender(){
        return $this->belongsTo(Card::class,'sender_card','token');
    }

    public function receiver(){
        return $this->belongsTo(Card::class,'receiver_card','token');
    }
}
