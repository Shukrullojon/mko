<?php

namespace App\Services;

use App\Models\Pages\MerchantTerminal;

class MerchantService
{
    public static function debit(){

    }

    public static function credit($data){
        $merchant = MerchantTerminal::where('merchant_id',$data['merchant_id'])->first();
        if(empty($merchant)){
            return false;
        }
        $merchant->update([
            'balance' => $merchant->balance + $data['amount'],
        ]);
        return true;
    }
}
