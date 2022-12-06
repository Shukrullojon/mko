<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pages\MerchantPeriod;
use App\Services\GraphicService;
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
        $mp = MerchantPeriod::find($params['params']['period_id']);
        $graphic = GraphicService::done([
            'period' => $mp->period,
            'percentage' => $mp->percentage,
            'amount' => $params['params']['amount'],
        ]);
        return $graphic;
    }

}
