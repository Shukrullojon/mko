<?php

namespace App\Services;

use App\Models\Pages\Account;
use App\Models\Pages\Transaction;
use App\Models\Pages\TransactionAccount;

class TransactionAccountService
{
    public static function transaction()
    {
        $transactions = Transaction::where('is_sent', 0)->take(20)->get();
        $account = Account::where('type', 2)->first();
        foreach ($transactions as $transaction) {
            $abs = AbsService::transaction([
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
                    "name" => "перевод (дата: " . date("Y-m-d H:i:s") . ") mko test"
                ],
                'amount' => $transaction->amount,
            ]);
            if (isset($abs['status']) and $abs['status']) {
                $debit = CardService::debit([
                    'token' => $transaction->receiver_card,
                    'amount' => $transaction->amount,
                ]);
                $transaction->update([
                    'is_sent' => 1,
                ]);
                TransactionAccount::create([
                    'sender_id' => $account->id,
                    'receiver_id' => $transaction->account->id,
                    'amount' => $transaction->amount,
                    'transactionId' => $abs['data']['responseBody']['createdDocuments'][0]['transactionId'],
                    'status' => 1,
                ]);
            }
        }
    }

}
