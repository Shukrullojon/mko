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
}
