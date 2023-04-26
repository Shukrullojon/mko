<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $guarded = [];

    public function merchant() {
        return $this->belongsTo(Merchant::class);
    }
    public static function get(){
        $brands = Brand::all();
        return $brands;
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            DB::connection('mysql_clon')->table('ucoin_brands')->insert([
                'brand_id' => $model->id,
                'name' => $model->name,
                'logo' => $model->logo,
                'purpose' => $model->purpose,
                'is_unired' => $model->is_unired,
                'status' => $model->status,
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
