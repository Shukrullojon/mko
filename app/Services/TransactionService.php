<?php

namespace App\Services;

use App\Gateway\MobileGateway;
use App\Models\Pages\Account;
use App\Models\Pages\Card;
use App\Models\Pages\Payment;
use App\Models\Pages\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public static function transaction(){
        $payments = Payment::where('is_transaction',0)->get();
        $accountItunisoft = Account::where('type',3)->first();
        $accountMko = Account::where('type',4)->first();
        foreach($payments as $payment){
            DB::transaction(function () use ($payment, $accountItunisoft,$accountMko){
                $merchantTr = Transaction::create([
                    'sender_card' => $payment->client->card->token,
                    'receiver_card' => $payment->merchant->account->card->token,
                    'account_id' => $payment->merchant->account->id,
                    'payment_id' => $payment->id,
                    'amount' => $payment->amount * ($payment->merchant->account->percentage/100),
                    'cost_amount' => $payment->amount,
                    'percentage' => $payment->merchant->account->percentage,
                    'status' => 0,
                    'is_sent' => 0,
                ]);
                $itunisoftTr = Transaction::create([
                    'sender_card' => $payment->client->card->token,
                    'receiver_card' => $accountItunisoft->card->token,
                    'account_id' => $accountItunisoft->id,
                    'payment_id' => $payment->id,
                    'amount' => $payment->amount * ($accountItunisoft->percentage/100),
                    'cost_amount' => $payment->amount,
                    'percentage' => $accountItunisoft->percentage,
                    'status' => 0,
                    'is_sent' => 0,
                ]);
                $mkoTr = Transaction::create([
                    'sender_card' => $payment->client->card->token,
                    'receiver_card' => $accountMko->card->token,
                    'account_id' => $accountMko->id,
                    'payment_id' => $payment->id,
                    'amount' => $payment->amount * ($accountMko->percentage/100),
                    'cost_amount' => $payment->amount,
                    'percentage' => $accountMko->percentage,
                    'status' => 0,
                    'is_sent' => 0,
                ]);
                $payment->update([
                    'is_transaction' => 1,
                ]);
            });
        }

        $transactions = Transaction::where('status',0)->get();
        foreach($transactions as $transaction){
            // debit hold
            $debitHold = CardService::holdDebit([
                'token' => $transaction->sender_card,
                'amount' => $transaction->amount,
            ]);
            // credit
            if($debitHold){
                $credit = CardService::credit([
                    'token' => $transaction->receiver_card,
                    'amount' => $transaction->amount,
                ]);
                if($credit){
                    $transaction->update([
                        'status' => 1,
                    ]);
                }
            }
        }
    }

}
