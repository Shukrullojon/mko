<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\Transfer;
use App\Services\AbsService;
use App\Services\CardService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransferController extends Controller
{
    public function account($params)
    {
        return [
            'error' => [
                'code' => 500,
                'message' => [
                    'uz' => "Bu xizmat o'chirildi",
                    'ru' => "Bu xizmat o'chirildi",
                    'en' => "Bu xizmat o'chirildi",
                ],
            ],
        ];
        $transfer = Transfer::create([
            'method' => 'transfer.ucoin',
            'status' => 0,
            'sender' => $params['params']['sender'],
            'receiver' => $params['params']['receiver'],
            'amount' => $params['params']['amount'],
            'user_id' => $params['user']['id'],
            'uuid' => Str::uuid(),
        ]);
        $debit = CardService::debit([
            'token' => $transfer->sender,
            'amount' => $transfer->amount
        ]);
        if($debit){
            $transfer->update([
                'status' => 2,
            ]);
            $account = Account::where('type', 2)->first();
            $merAccount = Account::where('number',$params['params']['receiver'])->first();
            $abs = AbsService::transaction([
                'type' => "101",
                'sender_account' => $account->number,
                'sender_code_filial' => $account->filial,
                'sender_tax' => $account->inn,
                'sender_name' => $account->name,
                'recipient_account' => $merAccount->account,
                'recipient_code_filial' => $merAccount->filial,
                'recipient_tax' => $merAccount->inn,
                'recipient_name' => $merAccount->name,
                'purpose' => [
                    "code" => "00668",
                    "name" => "перевод (дата: " . date("Y-m-d H:i:s") . ") "."} ID{V".str_pad($transfer->id,12,'0',STR_PAD_LEFT)."V}",
                ],
                'amount' => $transfer->amount,
            ]);
            if (isset($abs['status']) and $abs['status']) {
                $transfer->update([
                    'transactionId' => $abs['data']['responseBody']['createdDocuments'][0]['transactionId'],
                    'status' => 4,
                ]);
            }else{
                $transfer->update([
                    'status' => 5
                ]);
            }
        }
        return $this->success($transfer);
    }

    public function ucoin($params)
    {
        return [
            'error' => [
                'code' => 500,
                'message' => [
                    'uz' => "Bu xizmat o'chirildi",
                    'ru' => "Bu xizmat o'chirildi",
                    'en' => "Bu xizmat o'chirildi",
                ],
            ],
        ];
        $transfer = Transfer::create([
            'method' => 'transfer.ucoin',
            'status' => 0,
            'sender' => $params['params']['sender'],
            'receiver' => $params['params']['receiver'],
            'amount' => $params['params']['amount'],
            'user_id' => $params['user']['id'],
            'uuid' => Str::uuid(),
        ]);

        $debit = CardService::debit([
            'token' => $transfer->sender,
            'amount' => $transfer->amount
        ]);
        if ($debit) {
            $transfer->update([
                'status' => 2,
            ]);
            $credit = CardService::credit([
                'token' => $transfer->receiver,
                'amount' => $transfer->amount
            ]);
            if ($credit) {
                $transfer->update([
                    'status' => 4,
                ]);
            } else {
                $transfer->update([
                    'status' => 5,
                ]);

            }
        }
        return $this->success($transfer);
    }

    public function success($transfer){
        return [
            'method' => $transfer->method,
            'status' => $transfer->status,
            'sender' => $transfer->sender,
            'receiver' => $transfer->receiver,
            'amount' => $transfer->amount,
            'tr_id' => $transfer->uuid,
        ];
    }

    public function state($params)
    {
        return $this->success(Transfer::where('uuid', $params['params']['tr_id'])->first());
    }

}
