<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Card extends Model
{
    use HasFactory;

    protected $table = 'cards';

    protected $guarded = [];

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function account(){
        return $this->hasOne(Account::class);
    }

    public function paymentSum()
    {
        return $this->hasOne(Payment::class, 'sender_card', 'token')->select(DB::raw("sum(amount) as amount"))->where('status',1);
    }
}
