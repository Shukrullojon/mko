<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\MerchantPeriod;
use App\Services\AbsService;
use App\Services\GraphicService;
use Illuminate\Http\Request;
use App\Models\Pages\Merchant;

class MerchantController extends Controller
{
    public function period($params)
    {
        try {
            $merchant = Merchant::where('key', $params['params']['key'])->first();
            $account = Account::where('type', 3)->first();
            $accountMko = Account::where('type', 4)->first();
            $percentage = $account->percentage + $accountMko->percentage + $merchant->account->percentage;
            return [
                'commission' => 0,
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
        } catch (\Exception $exception) {
            return $this->errorException($exception);
        }
    }

    public function schedule($params)
    {
        try {
            $mp = MerchantPeriod::find($params['params']['period_id']);
            $graphic = GraphicService::done([
                'period' => $mp->period,
                'percentage' => 0,
                'amount' => $params['params']['amount'],
            ]);
            return $graphic;
        } catch (\Exception $exception) {
            return $this->errorException($exception);
        }
    }

    public function balance($params)
    {
        try {
            $abs = AbsService::getAccountDetails([
                'account' => $params['params']['account']
            ]);
            return $abs["data"]["responseBody"] ?? [];
        } catch (\Exception $exception) {
            return $this->errorException($exception);
        }
    }

    public function errorException($exception)
    {
        return [
            'error' => [
                'code' => 500,
                'message' => [
                    'uz' => $exception->getMessage(),
                    'ru' => $exception->getMessage(),
                    'en' => $exception->getMessage(),
                ],
            ],
        ];
    }
}
