<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Api\V1\ErrorHelper;
use App\Http\Controllers\Controller;
use App\Models\Pages\Card;
use App\Models\Pages\Client;
use App\Models\Pages\Merchant;
use App\Models\Pages\MerchantPeriod;
use App\Models\Pages\Payment;
use App\Services\CardService;
use App\Services\MerchantService;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function confirm($params){
        $card = Card::where('token',$params['params']['token'])->first();
        $client = Client::where('card_id',$card->id)->first();
        $merchant = Merchant::where('key',$params['params']['key'])->first();
        $period = MerchantPeriod::where('id',$params['params']['period_id'])->where('merchant_id',$merchant->id)->first();
        if(empty($card) or empty($client) or empty($merchant) or empty($period)){
            return ErrorHelper::error300();
        }

        if($card->balance < ($params['params']['amount'] + $params['params']['amount']*($period->percentage/100))){
            return ErrorHelper::error301();
        }

        $payment = Payment::create([
            'client_id' => $client->id,
            'merchant_id' => $merchant->id,
            'period' => $period->period,
            'percentage' => $period->percentage,
            'sender_card' => $card->token,
            'cost' => $params['params']['amount'],
            'amount' => $params['params']['amount'] + $params['params']['amount']*($period->percentage/100),
            'date' => date("Y-m-d"),
            'is_transaction' => 0,
            'status' => 0,
            'tr_id' => Str::uuid(),
        ]);

        try {
            $debit = CardService::debit([
                'token' => $card->token,
                'expire' => $card->expire,
                'amount' => $params['params']['amount'] + $params['params']['amount'] * ($period->percentage / 100),
            ]);
            if($debit){
                $credirMerchant = MerchantService::credit([
                    'merchant_id' => $merchant->id,
                    'amount' => $params['params']['amount'] + $params['params']['amount'] * ($period->percentage / 100),
                ]);

                $payment->update([
                    'status' => 1,
                ]);
            }
            return ['tr_id' => $payment->tr_id];
        }catch(\Exception $e){
            return [
                'error' => [
                    "code" => 400,
                    "message" => [
                        "uz" => $e->getMessage(),
                        "ru" => $e->getMessage(),
                        "en" => $e->getMessage(),
                    ],
                ],
            ];
        }
    }
}
