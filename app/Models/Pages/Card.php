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

        self::created(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_brands')->insert([
                'card_id' => $model->id,
                'number' => $model->name,
                'expire' => $model->logo,
                'type' => $model->purpose,
                'owner' => $model->is_unired,
                'balance' => $model->status,
                'hod_amount' => $model->status,
                'phone' => $model->status,
                'token' => $model->status,
                'status' => $model->status
            ]);
        });

        self::updated(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_brands')->where('brand_id',$model->id)->update([
                'brand_id' => $model->id,
                'name' => $model->name,
                'logo' => $model->logo,
                'purpose' => $model->purpose,
                'is_unired' => $model->is_unired,
                'status' => $model->status,
            ]);
        });
    }
}
