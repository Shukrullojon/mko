<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages\Card;

class CardController extends Controller
{
    public function info($params){
        try {
            $card = Card::where('token',$params['params']['token'])->first();
            return [
                'number' => $card->number,
                'expire' => $card->expire,
                'owner' => $card->owner,
                'balance' => $card->balance,
                'phone' => $card->phone,
                'status' => $card->status,
            ];
        }catch (\Exception $exception){
            return $this->errorException($exception);
        }
    }
    /* - */
    public function getCard($params){
            $cards = Card::where('phone', $params['params']['phone'])->get();
            $arr = [];
            if($cards) {
                foreach ($cards as $card) {
                    $arr[] = $card->number;
                }

            }else {
                return [
                    'msg' => 'Card not found'
                ];
            }
        return [
            'cards' => $arr
        ];

    }

    public function card($params){
        try {
            $card = Card::where('token',$params['params']['token'])->first();
            return [
                'limit' => (int)$card->client->limit ?? "",
                'balance' => (int)$card->balance ?? "",
                'transaction_amount' => (int)$card->paymentSum->amount ?? "",
            ];
        }catch (\Exception $exception){
            return $this->errorException($exception);
        }
    }

    public function errorException($exception){
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
