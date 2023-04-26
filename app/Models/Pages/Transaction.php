<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_transactions')->insert([
                'transaction_id' => $model->id,
                'sender_card' => $model->sender_card,
                'receiver_card' => $model->receiver_card,
                'ucaccount_id' => $model->ucaccount_id,
                'type' => $model->type,
                'ucpayment_id' => $model->ucpayment_id,
                'amount' => $model->amount,
                'percentage' => $model->percentage,
                'status' => $model->status,
                'is_sent' => $model->is_sent,
            ]);
        });

        self::updated(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_transactions')->where('transaction_id',$model->id)->update([
                'transaction_id' => $model->id,
                'sender_card' => $model->sender_card,
                'receiver_card' => $model->receiver_card,
                'ucaccount_id' => $model->ucaccount_id,
                'type' => $model->type,
                'ucpayment_id' => $model->ucpayment_id,
                'amount' => $model->amount,
                'percentage' => $model->percentage,
                'status' => $model->status,
                'is_sent' => $model->is_sent,
            ]);
        });
    }
}
