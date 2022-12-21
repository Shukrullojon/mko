<?php

namespace App\Services;

use App\Models\Pages\Account;
use App\Models\Pages\Transaction;

class TransactionAccountService
{
    public static function transaction()
    {
        $transactions = Transaction::where('is_sent', 0)->take(20)->get();
        $account = Account::where('type', 2)->first();
        foreach ($transactions as $transaction) {

            $abs = AbsService::transaction([
                'type' => 101,
                'sender_account' => $account->number,
                'sender_code_filial' => $account->filial,
                'sender_tax' => $account->inn,
                'sender_name' => $account->name,
                'recipient_account' => $transaction->account->number,
                'recipient_code_filial' => $transaction->account->filial,
                'recipient_tax' => $transaction->account->inn,
                'recipient_name' => $transaction->account->name,
                'purpose' => [

                ],
                'amount' => $transaction->amount,
            ]);
        }
    }

}
