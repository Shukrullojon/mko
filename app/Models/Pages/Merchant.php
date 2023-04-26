<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Merchant extends Model
{
    use HasFactory;

    protected $table = 'merchants';

    protected $guarded = [];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function account(){
        return $this->belongsTo(Account::class);
    }
    public function terminal(){
        return $this->belongsTo(MerchantTerminal::class);
    }

    public function periods(){
        return $this->hasMany(MerchantPeriod::class)->select('id','period','percentage')->where('status',1);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_merchants')->insert([
                'merchant_id' => $model->id,
                'ucbrand_id' => $model->ucbrand_id,
                'key' => $model->key,
                'name' => $model->name,
                'filial' => $model->filial,
                'address' => $model->address,
                'uzcard_merchnat_id' => $model->uzcard_merchnat_id,
                'uzcard_terminal_id' => $model->uzcard_terminal_id,
                'humo_merchant_id' => $model->humo_merchant_id,
                'humo_terminal_id' => $model->humo_terminal_id,
                'is_register_humo' => $model->is_register_humo,
                'is_register_uzcard' => $model->is_register_uzcard,
                'ucaccount_id' => $model->ucaccount_id,
                'status' => $model->status,
            ]);
        });

        self::updated(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_merchants')->where('merchant_id',$model->id)->update([
                'merchant_id' => $model->id,
                'ucbrand_id' => $model->ucbrand_id,
                'key' => $model->key,
                'name' => $model->name,
                'filial' => $model->filial,
                'address' => $model->address,
                'uzcard_merchnat_id' => $model->uzcard_merchnat_id,
                'uzcard_terminal_id' => $model->uzcard_terminal_id,
                'humo_merchant_id' => $model->humo_merchant_id,
                'humo_terminal_id' => $model->humo_terminal_id,
                'is_register_humo' => $model->is_register_humo,
                'is_register_uzcard' => $model->is_register_uzcard,
                'ucaccount_id' => $model->ucaccount_id,
                'status' => $model->status,
            ]);
        });
    }
}
