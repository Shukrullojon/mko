<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\Transaction;
use App\Models\Pages\TransactionAccount;
use App\Services\AbsService;
use App\Services\CardService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function send($params)
    {
        try {
            $oper = AbsService::operDay();
            if (isset($oper['status']) and $oper['status'] and isset($oper['data']['code']) and $oper['data']['code'] == 0){
                $transaction = Transaction::where('id', $params['params']['transaction_id'])->where('type', 0)->where('is_sent', 0)->where('status', 1)->first();
                $account = Account::where('type', 2)->first();
                $bAccount = Account::where('type', 5)->first();

                $tr1 = TransactionAccount::create([
                    'transaction_id' => $transaction->id,
                    'sender_id' => $account->id,
                    'receiver_id' => $transaction->account->id,
                    'amount' => ($transaction->amount * (100 - $bAccount->percentage)) / 100,
                    'status' => 0,
                ]);

                $tr2 = TransactionAccount::create([
                    'transaction_id' => $transaction->id,
                    'sender_id' => $account->id,
                    'receiver_id' => $bAccount->id,
                    'amount' => ($transaction->amount * $bAccount->percentage) / 100,
                    'status' => 0,
                ]);

                $debit = CardService::debit([
                    'amount' => $transaction->amount,
                    'token' => $transaction->receiver_card,
                ]);
                if ($debit) {
                    $transaction->update([
                        'is_sent' => 1,
                    ]);

                    $trAccount = TransactionAccount::where('status',0)->get();
                    foreach ($trAccount as $tr){
                        $abs = AbsService::transaction([
                            'type' => "101",
                            'sender_account' => $tr->sender->number,
                            'sender_code_filial' => $tr->sender->filial,
                            'sender_tax' => $tr->sender->inn,
                            'sender_name' => $tr->sender->name,
                            'recipient_account' => $tr->receiver->number,
                            'recipient_code_filial' => $tr->receiver->filial,
                            'recipient_tax' => $tr->receiver->inn,
                            'recipient_name' => $tr->receiver->name,
                            'purpose' => [
                                "code" => "00668",
                                "name" => "UCOIN ".$tr->transaction->payment->senderCard->number.", ".$tr->transaction->payment->senderCard->owner." Оплата ".number_format($tr->transaction->payment->amount/100)." сум, За вычетом комиссии ".$tr->transaction->percentage." % + 1,5 %, (дата: " .$tr->transaction->payment->date. ") "." ID{V" . str_pad($tr->transaction->payment->id, 12, '0', STR_PAD_LEFT) . "V}",
                            ],
                            'amount' => $tr->amount,
                        ]);
                        if(isset($abs['status']) and $abs['status']){
                            $tr->update([
                                'status' => 1,
                                'transactionId' => $abs['data']['responseBody']['createdDocuments'][0]['transactionId'],
                            ]);
                        }
                    }
                    return [];
                }else{
                    $tr1->update([
                        'status' => 11,
                    ]);
                    $tr2->update([
                        'status' => 11,
                    ]);
                }
            }else{
                return [
                    "error" => [
                        "code" => 502,
                        "message" => [
                            'uz' => "Bank kuni yopilgan!!!",
                            'ru' => "Bank kuni yopilgan!!!",
                            'en' => "Bank kuni yopilgan!!!",
                        ],
                    ],
                ];
            }

        } catch (\Exception $exception) {
            return [
                "error" => [
                    "code" => 501,
                    "message" => [
                        'uz' => $exception->getMessage(),
                        'ru' => $exception->getMessage(),
                        'en' => $exception->getMessage(),
                    ],
                ],
            ];
        }
    }
}
