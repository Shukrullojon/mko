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

    public static function holdCredit($data){
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

    public static function holdDebit($data){
        $card = Card::where('token',$data['token'])->first();
        if(empty($card) or $data['amount'] > $card->hold_amount){
            return false;
        }
        $card->update([
            'hold_amount' => $card->hold_amount - $data['amount'],
        ]);
        return true;
    }
}
