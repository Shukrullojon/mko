<?php

namespace App\Services;

use App\Models\Pages\Card;

class CardService
{
    public static function debit($data){

    }

    public static function credit($data){

    }

    public static function hold($data){
        try{
            $card = Card::where('token',$data['token'])->where('expire',$data['expire'])->first();
            if(empty($card) or $data['amount'] > $card->balance or $card->status != 1){
                return false;
            }
            $card->update([
                'balance' => $card->balance - $data['amount'],
                'hold_amount' => $card->hold_amount + $data['amount'],
            ]);
            return true;
        }catch(\Exception $exception){
            return false;
        }
    }
}
