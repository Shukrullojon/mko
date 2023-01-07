<?php

namespace App\Services;

use App\Gateway\MobileGateway;
use App\Models\Pages\Account;
use App\Models\Pages\Card;
use App\Models\Pages\MerchantTerminal;
use App\Models\Pages\Payment;
use App\Models\Pages\Transaction;
use App\Models\Pages\TransactionTerminal;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public static function transaction()
    {
        $payments = Payment::where('is_transaction', 0)->get();
        $accountItUnisoft = Account::where('type', 3)->first();
        $accountMko = Account::where('type', 4)->first();

        foreach ($payments as $payment) {
            DB::transaction(function () use ($payment, $accountItUnisoft, $accountMko) {
                $merchantPercentage = 100 - ($accountItUnisoft->percentage + $accountMko->percentage);
                Transaction::create([
                    'sender_card' => $payment->client->card->token,
                    'receiver_card' => $payment->merchant->account->card->token,
                    'type' => 0,
                    'account_id' => $payment->merchant->account->id,
                    'payment_id' => $payment->id,
                    'amount' => ($payment->amount * $merchantPercentage) / 100,
                    'percentage' => $merchantPercentage,
                    'status' => 0,
                    'is_sent' => 0,
                ]);

                // Mko
                Transaction::create([
                    'sender_card' => $payment->client->card->token,
                    'receiver_card' => $accountMko->card->token,
                    'type' => 1,
                    'account_id' => $accountMko->id,
                    'payment_id' => $payment->id,
                    'amount' => ($payment->amount * $accountMko->percentage) / 100,
                    'percentage' => $accountMko->percentage,
                    'status' => 0,
                    'is_sent' => 0,
                ]);

                // ItUnisoft
                Transaction::create([
                    'sender_card' => $payment->client->card->token,
                    'receiver_card' => $accountItUnisoft->card->token,
                    'type' => 1,
                    'account_id' => $accountItUnisoft->id,
                    'payment_id' => $payment->id,
                    'amount' => ($payment->amount * $accountItUnisoft->percentage) / 100,
                    'percentage' => $accountItUnisoft->percentage,
                    'status' => 0,
                    'is_sent' => 0,
                ]);

                $payment->update([
                    'is_transaction' => 1,
                ]);
            });
        }

        $transactions = Transaction::where('status', 0)->get();
        foreach ($transactions as $transaction) {
            $debitMerchant = MerchantService::debit([
                'merchant_id' => $transaction->payment->merchant_id,
                'amount' => $transaction->amount,
            ]);
            if ($debitMerchant) {
                $credit = CardService::credit([
                    'token' => $transaction->receiver_card,
                    'amount' => $transaction->amount,
                ]);
                if ($credit) {
                    $transaction->update([
                        'status' => 1,
                    ]);
                } else {
                    $transaction->update([
                        'status' => -10,
                    ]);
                }
            }
        }

    }

}
