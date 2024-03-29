<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages\Card;

class CardController extends Controller
{
    public function info($params)
    {
        try {
            $card = Card::where('token', $params['params']['token'])->first();
            return [
                'number' => $card->number,
                'expire' => $card->expire,
                'owner' => $card->owner,
                'balance' => $card->balance,
                'phone' => $card->phone,
                'status' => $card->status,
            ];
        } catch (\Exception $exception) {
            return $this->errorException($exception);
        }
    }

    /* - */
    public function getCard($params)
    {
        $card = Card::where('phone', $params['params']['phone'])->first();
        if ($card) {
            return [
                'card' => $card->number,
                'balance' => $card->balance
            ];
        } else {
            return [
                'msg' => 'Card not found'
            ];
        }

    }

    public function card($params)
    {
        try {
            $card = Card::where('token', $params['params']['token'])->first();
            return [
                'limit' => (int)$card->client->limit ?? "",
                'balance' => (int)$card->balance ?? "",
                'transaction_amount' => (int)$card->paymentSum->amount ?? "",
            ];
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
