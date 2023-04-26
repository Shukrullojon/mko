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
            DB::connection('mysql_clon')->table('clients_ucoin')->insert([
                'client_id' => $model->id,
                'application_id' => $model->application_id
            ]);
        });

        self::updated(function ($model) {
            DB::connection('mysql_clon')->table('clients_ucoin')->where('client_id',$model->id)->update([
                'application_id' => $model->pnfl
            ]);
        });
    }
}
