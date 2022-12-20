<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTerminal extends Model
{
    use HasFactory;

    protected $table = 'transaction_terminals';

    protected $guarded = [];

}
