<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitHistory extends Model
{
    use HasFactory;

    protected $table = 'limit_histories';

    protected $guarded = [];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
