<?php

namespace App\Services;

use App\Gateway\AbsGateway;

class AbsService
{
    public static function transaction($data)
    {
        $data = [
            "jsonrpc" => "2.0",
            "id" => rand(10000, 99999),
            "method" => "iabs.transactions.create.transactions",
            "params" => [
                "type" => $data['type'],
                "sender" => [
                    "account" => $data['sender_account'],
                    "codeFilial" => $data['sender_code_filial'],
                    "tax" => $data['sender_tax'],
                    "name" => $data['sender_name'],
                ],
                "recipient" => [
                    "account" => $data['recipient_account'],
                    "codeFilial" => $data['recipient_code_filial'],
                    "tax" => $data['recipient_tax'],
                    "name" => $data['recipient_name'],
                ],
                "purpose" => $data['purpose'],
                "amount" => (float)$data['amount']
            ]
        ];
        return AbsGateway::fire('POST', 'api/v1/bank', $data);
    }

}
