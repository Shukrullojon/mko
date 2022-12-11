<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pages\Brand;
use App\Models\Pages\Merchant;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function get(){
        $brands = Brand::select("id","name","logo","is_unired","status")->where("status",1)->get();
        return [
            'partners' => $brands,
        ];
    }

    public function merchant($params){
        $merchants = Merchant::where('brand_id',$params['params']['partner_id'])->get();
        $brand = Brand::find($params['params']['partner_id']);
        return [
            'merchants' => $merchants,
            'brand' => [
                'name' => $brand->name,
                'logo' => $brand->logo,
            ],
        ];
    }

    public function a($params){
        return [];
    }

}
