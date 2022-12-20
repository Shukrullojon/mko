<?php

namespace App\Services;

use App\Models\Pages\MerchantTerminal;
use App\Models\Pages\TransactionTerminal;

class MerchantService
{
    public static function credit($data){
        $merchant = MerchantTerminal::where('merchant_id',$data['merchant_id'])->first();
        if(empty($merchant)){
            return false;
        }
        TransactionTerminal::create([
            'terminal_id' => $merchant->id,
            'card_id' => $data['card_id'],
            'type' => 1,
            'amount' => $data['amount'],
        ]);
        $merchant->update([
            'balance' => $merchant->balance + $data['amount'],
        ]);
        return true;
    }

    public static function debit($data){
        $merchant = MerchantTerminal::where('merchant_id',$data['merchant_id'])->first();
        if(empty($merchant)){
            return false;
        }
        TransactionTerminal::create([
            'terminal_id' => $merchant->id,
            'card_id' => $data['card_id'],
            'type' => 11,
            'amount' => $data['amount'],
        ]);
        $merchant->update([
            'balance' => $merchant->balance - $data['amount'],
        ]);
        return true;

    }
}
