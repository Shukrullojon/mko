<?php

namespace App\Services;

use App\Models\Pages\Card;

class CardService
{
    public static function debit($data){
        $card = Card::where('token',$data['token'])->first();
        if(empty($card) or $data['amount'] > $card->balance){
            return false;
        }
        $card->update([
            'balance' => $card->balance - $data['amount'],
        ]);
        return true;
    }

    public static function credit($data){
        $card = Card::where('token',$data['token'])->first();
        if(empty($card)){
            return false;
        }
        $card->update([
            'balance' => $card->balance + $data['amount'],
        ]);
        return true;
    }
}
