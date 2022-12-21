<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardTransaction extends Model
{
    use HasFactory;

    protected $table = 'card_transactions';

    protected $guarded = [];
}
