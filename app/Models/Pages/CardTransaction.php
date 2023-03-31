<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CardTransaction extends Model
{
    use HasFactory;

    protected $table = 'card_transactions';

    protected $guarded = [];

    public function payment() {
        return $this->belongsTo(Payment::class);
    }
}
