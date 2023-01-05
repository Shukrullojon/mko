<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages\Card;

class CardController extends Controller
{
    public function info($params){
        $card = Card::where('token',$params['params']['token'])->first();
        return [
            'number' => $card->number,
            'expire' => $card->expire,
            'owner' => $card->owner,
            'balance' => $card->balance,
            'phone' => $card->phone,
            'status' => $card->status,
        ];
    }

    public function card($params){
        $card = Card::where('token',$params['params']['token'])->first();
        return [
            'limit' => (int)$card->client->limit ?? "",
            'balance' => (int)$card->balance ?? "",
            'transaction_amount' => (int)$card->paymentSum->amount ?? "",
        ];
    }
}
