<?php

namespace App\Services;

use App\Gateway\MobileGateway;
use App\Models\Pages\Account;
use App\Models\Pages\Payment;
use App\Models\Pages\Transaction;

class TransactionService
{
    public static function transaction(){
        $payments = Payment::where('is_transaction',0)->get();
        $accountItunisoft = Account::where('type',3)->first();
        $accountMko = Account::where('type',4)->first();

        foreach($payments as $payment){
            $merchantTr = Transaction::create([
                'sender_card' => $payment->client->card->number,
                'receiver_card' => $payment->merchant->account->card->number,
                'account_id' => $payment->merchant->account->id,
                'payment_id' => $payment->id,
                'amount' => $payment->amount * ($payment->merchant->account->percentage/100),
                'cost_amount' => $payment->amount,
                'percentage' => $payment->merchant->account->percentage,
                'status' => 0,
                'is_sent' => 0,
            ]);

            $itunisoftTr = Transaction::create([
                'sender_card' => $payment->client->card->number,
                'receiver_card' => $accountItunisoft->card->number,
                'account_id' => $accountItunisoft->id,
                'payment_id' => $payment->id,
                'amount' => $payment->amount * ($accountItunisoft->percentage/100),
                'cost_amount' => $payment->amount,
                'percentage' => $accountItunisoft->percentage,
                'status' => 0,
                'is_sent' => 0,
            ]);

            $mkoTr = Transaction::create([
                'sender_card' => $payment->client->card->number,
                'receiver_card' => $accountMko->card->number,
                'account_id' => $accountMko->id,
                'payment_id' => $payment->id,
                'amount' => $payment->amount * ($accountMko->percentage/100),
                'cost_amount' => $payment->amount,
                'percentage' => $accountMko->percentage,
                'status' => 0,
                'is_sent' => 0,
            ]);


        }
    }

}
