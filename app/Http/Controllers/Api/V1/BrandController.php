<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages\Brand;

class BrandController extends Controller
{
    public function get(){
        try{
            $brandes = Brand::select("id","name_uz","name_ru","name_en","logo")->where('status',1)->get()->toArray();
            return $brandes;
        }catch(\Exception $exception){
            return [
                "error" =>[
                    "code" => 424,
                    "message" => [
                        "uz" => $exception->getMessage(),
                        "ru" => $exception->getMessage(),
                        "en" => $exception->getMessage(),
                    ],
                ],
            ];
        }
    }
}
