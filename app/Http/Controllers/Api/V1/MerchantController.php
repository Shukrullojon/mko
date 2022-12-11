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
            'periods' => $merchant->periods,
            'merchant' => [
                'key' => $merchant->key,
                'name' => $merchant->name,
                'filial' => $merchant->filial,
                'address' => $merchant->address,
                'uzcard_merchant_id' => $merchant->uzcard_merchant_id,
                'uzcard_terminal_id' => $merchant->uzcard_terminal_id,
                'humo_merchant_id' => $merchant->humo_merchant_id,
                'humo_terminal_id' => $merchant->humo_terminal_id,
                'is_register_humo' => $merchant->is_register_humo,
                'is_register_uzcard' => $merchant->is_register_uzcard,
            ],
            'brand' => [
                'name' => $merchant->brand->name ?? "",
                'logo' => $merchant->brand->logo ?? "",
            ],
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
