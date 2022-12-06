<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
