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

    public static function boot()
    {
        parent::boot();

//        self::created(function ($model) {
//            return DB::connection('mysql_clon')->table('ucoin_cards')->insert([
//                'card_id' => $model->id,
//                'number' => $model->number,
//                'expire' => $model->expire,
//                'type' => $model->type,
//                'owner' => $model->owner,
//                'balance' => $model->balance,
//                'hold_amount' => $model->hold_amount,
//                'phone' => $model->phone,
//                'token' => $model->token,
//                'status' => $model->status,
//                'created_at' => $model->created_at,
//                'updated_at' => $model->updated_at,
//            ]);
//        });

        self::updated(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_cards')->where('card_id',$model->id)->update([
                'card_id' => $model->id,
                'number' => $model->number,
                'expire' => $model->expire,
                'type' => $model->type,
                'owner' => $model->owner,
                'balance' => $model->balance,
                'hod_amount' => $model->hod_amount,
                'phone' => $model->phone,
                'token' => $model->token,
                'status' => $model->status
            ]);
        });
    }
}
