<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pages\Transfer;
use App\Services\CardService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransferController extends Controller
{
    public function account($params)
    {

    }

    public function ucoin($params)
    {
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
        return [
            'tr_id' => $transfer->uuid,
            'status' => $transfer->status,
        ];
    }

    public function state($params)
    {
        $transfer = Transfer::where('uuid', $params['params']['tr_id'])->first();
        return [
            'tr_id' => $transfer->uuid,
            'status' => $transfer->status,
        ];
    }

}
