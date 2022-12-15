<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $guarded = [];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }

    public function senderCard(){
        return $this->belongsTo(Card::class,'sender_card','token');
    }

    public function transactions(){
        return $this->hasMany(Transaction::class,'id','payment_id');
    }
}
