<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\Transaction;
use App\Services\AbsService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function send($params){
        $transaction = Transaction::where('id',$params['params']['transaction_id'])->where('type',0)->where('is_sent',0)->where('status',0)->first();
        if(empty($transaction)){
            return [
                "error" => [
                    "code" => 500,
                    "message" => [

                    ],
                ],
            ];
        }
        $account = Account::where('type', 2)->first();
        $bAccount = Account::where('type',5)->first();
        /*$abs = AbsService::transaction([
            'type' => "101",
            'sender_account' => $account->number,
            'sender_code_filial' => $account->filial,
            'sender_tax' => $account->inn,
            'sender_name' => $account->name,
            'recipient_account' => $transaction->account->number,
            'recipient_code_filial' => $transaction->account->filial,
            'recipient_tax' => $transaction->account->inn,
            'recipient_name' => $transaction->account->name,
            'purpose' => [
                "code" => "00668",
                "name" => "перевод (дата: " . date("Y-m-d H:i:s") . ") "."} ID{V".str_pad($transaction->id,12,'0',STR_PAD_LEFT)."V}",
            ],
            'amount' => ($transaction->amount * (100 -  $bAccount->percentage))/100,
        ]);

        $absBank = AbsService::transaction([
            'type' => "101",
            'sender_account' => $account->number,
            'sender_code_filial' => $account->filial,
            'sender_tax' => $account->inn,
            'sender_name' => $account->name,
            'recipient_account' => $bAccount->number,
            'recipient_code_filial' => $bAccount->filial,
            'recipient_tax' => $bAccount->inn,
            'recipient_name' => $bAccount->name,
            'purpose' => [
                "code" => "00668",
                "name" => "перевод (дата: " . date("Y-m-d H:i:s") . ") "."} ID{V".str_pad($transaction->id,12,'0',STR_PAD_LEFT)."V}",
            ],
            'amount' => ($transaction->amount*$bAccount->percentage) / 100,
        ]);*/

        $transaction->update([
            'is_sent' => 1,
        ]);
        return [];

    }
}
