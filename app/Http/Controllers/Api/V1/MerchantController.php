<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages\Merchant;

class MerchantController extends Controller
{
    public function period($params){
        $merchant = Merchant::where('key',$params['params']['key'])->first();
        return [
            'periods' => $merchant->periods
        ];
    }

    public function schedule($params){
        return $params['params'];
    }

}
