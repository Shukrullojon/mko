<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return $this->hasMany(Transaction::class,'payment_id','id');
    }
    public function card_transaction(){
        return $this->hasOne(CardTransaction::class);
    }
    public function card_active_transaction(){
        return $this->hasOne(CardTransaction::class)->where('status', 1);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_payments')->insert([
                'payment_id' => $model->id,
                'name' => $model->name,
                'ucclient_id' => $model->ucclient_id,
                'ucmerchant_id' => $model->ucmerchant_id,
                'period' => $model->period,
                'percentage' => $model->percentage,
                'sender_card' => $model->sender_card,
                'amount' => $model->amount,
                'date' => $model->date,
                'is_transaction' => $model->is_transaction,
                'status' => $model->status,
                'tr_id' => $model->tr_id,
                'is_sent' => $model->is_sent,
                'is_sent_code' => $model->is_sent_code,
            ]);
        });

        self::updated(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_payments')->where('payment_id',$model->id)->update([
                'payment_id' => $model->id,
                'name' => $model->name,
                'ucclient_id' => $model->ucclient_id,
                'ucmerchant_id' => $model->ucmerchant_id,
                'period' => $model->period,
                'percentage' => $model->percentage,
                'sender_card' => $model->sender_card,
                'amount' => $model->amount,
                'date' => $model->date,
                'is_transaction' => $model->is_transaction,
                'status' => $model->status,
                'tr_id' => $model->tr_id,
                'is_sent' => $model->is_sent,
                'is_sent_code' => $model->is_sent_code,
            ]);
        });
    }
}
