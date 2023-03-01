<?php

namespace App\Services;

use App\Models\Pages\Account;
use App\Models\Pages\Brand;
use App\Models\Pages\Card;
use App\Models\Pages\Transaction;
use App\Models\Pages\TransactionAccount;

class TransactionAccountService
{
    public static function transaction()
    {
        $transactions = Transaction::where('is_sent', 0)->take(20)->get();
        $account = Account::where('type', 2)->first();
        $bAccount = Account::where('type',5)->first();
        foreach ($transactions as $transaction) {
            if($transaction->type == 1){
                if($transaction->account->type == 4){
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
                            "name" => $transaction->payment->merchant->brand->purpose."перевод (дата: " . date("Y-m-d H:i:s") . ") "."} ID{V".str_pad($transaction->id,12,'0',STR_PAD_LEFT)."V}",
                        ],
                        'amount' => $transaction->amount,
                    ]);
                }else{
                    continue;
                }
                if (isset($abs['status']) and $abs['status']) {
                    $debit = CardService::debit([
                        'token' => $transaction->receiver_card,
                        'amount' => $transaction->amount,
                    ]);
                    $transaction->update([
                        'is_sent' => 1,
                    ]);
                    TransactionAccount::create([
                        'transaction_id' => $transaction->id,
                        'sender_id' => $account->id,
                        'receiver_id' => $transaction->account->id,
                        'amount' => $transaction->amount,
                        'transactionId' => $abs['data']['responseBody']['createdDocuments'][0]['transactionId'],
                        'status' => 1,
                    ]);
                }
            }else if($transaction->type == 0){
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
                        "name" => "перевод (дата: " . date("Y-m-d H:i:s") . ") "."} ID{V".str_pad($transaction->id,12,'0',STR_PAD_LEFT)."V}",
                    ],
                    'amount' => ($transaction->amount * (100 - $bAccount->percentage))/100,
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
                        "name" => $transaction->payment->merchant->filial." summa ".$transaction->amount." ".$bAccount->percentage." % дата".date("Y-m-d H:i:s")." ID{V".str_pad($transaction->id,12,'0',STR_PAD_LEFT)."V}",
                    ],
                    'amount' => ($transaction->amount*$bAccount->percentage) / 100,
                ]);
                if (isset($abs['status']) and $abs['status'] and $absBank['status']) {
                    $debit = CardService::debit([
                        'token' => $transaction->receiver_card,
                        'amount' => $transaction->amount,
                    ]);
                    $transaction->update([
                        'is_sent' => 1,
                    ]);
                    TransactionAccount::create([
                        'transaction_id' => $transaction->id,
                        'sender_id' => $account->id,
                        'receiver_id' => $transaction->account->id,
                        'amount' => ($transaction->amount * (100 - $bAccount->percentage)) / 100,
                        'transactionId' => $abs['data']['responseBody']['createdDocuments'][0]['transactionId'],
                        'status' => 1,
                    ]);

                    TransactionAccount::create([
                        'transaction_id' => $transaction->id,
                        'sender_id' => $account->id,
                        'receiver_id' => $bAccount->id,
                        'amount' => ($transaction->amount * $bAccount->percentage) / 100,
                        'transactionId' => $absBank['data']['responseBody']['createdDocuments'][0]['transactionId'],
                        'status' => 1,
                    ]);
                }
            }
        }
    }

}
