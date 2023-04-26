<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $guarded = [];

    public function merchant(){
        return $this->hasOne(Merchant::class);
    }

    public function card(){
        return $this->belongsTo(Card::class);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_clients')->insert([
                'account_id' => $model->id,
                'type' => $model->type,
                'number' => $model->number,
                'inn' => $model->inn,
                'name' => $model->name,
                'filial' => $model->filial,
                'uccard_id' => $model->uccard_id,
                'percentage' => $model->percentage,
            ]);
        });

        self::updated(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_accounts')->where('account_id',$model->id)->update([
                'account_id' => $model->id,
                'type' => $model->type,
                'number' => $model->number,
                'inn' => $model->inn,
                'name' => $model->name,
                'filial' => $model->filial,
                'uccard_id' => $model->uccard_id,
                'percentage' => $model->percentage,
            ]);
        });
    }
}
