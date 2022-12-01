<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'cards';

    protected $guarded = [];

    public function card(){
        return $this->belongsTo(Card::class);
    }
}
