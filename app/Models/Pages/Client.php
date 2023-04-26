<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $guarded = [];

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function transactions()
    {
        return $this->hasMany(Payment::class);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_clients')->insert([
                'client_id' => $model->id,
                'application_id' => $model->application_id,
                'client_code' => $model->client_code,
                'uccard_id' => $model->uccard_id,
                'limit' => $model->limit,
                'limit_status' => $model->limit_status,
                'used_limit' => $model->used_limit,
                'date_expiry' => $model->date_expiry,
                'pnfl' => $model->pnfl,
                'passport' => $model->passport,
                'first_name' => $model->first_name,
                'middle_name' => $model->middle_name,
                'last_name' => $model->last_name,
                'status' => $model->status,
                'is_sent' => $model->is_sent,
                'is_sent_code' => $model->is_sent_code,
            ]);
        });

        self::updated(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_clients')->where('client_id',$model->id)->update([
                'client_id' => $model->id,
                'application_id' => $model->application_id,
                'client_code' => $model->client_code,
                'uccard_id' => $model->uccard_id,
                'limit' => $model->limit,
                'limit_status' => $model->limit_status,
                'used_limit' => $model->used_limit,
                'date_expiry' => $model->date_expiry,
                'pnfl' => $model->pnfl,
                'passport' => $model->passport,
                'first_name' => $model->first_name,
                'middle_name' => $model->middle_name,
                'last_name' => $model->last_name,
                'status' => $model->status,
                'is_sent' => $model->is_sent,
                'is_sent_code' => $model->is_sent_code,
            ]);
        });
    }
}
