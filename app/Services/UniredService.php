<?php

namespace App\Services;

use App\Gateway\UniredGateway;

class UniredService
{
    public static function clientSent($data)
    {
        return UniredGateway::fire([
            "url" => "https://mko.unired.uz/api/client/create",
            "data" => [
                "client_id" => $data['client_id'],
                "client_code" => $data['client_code'],
                "application_id" => $data['application_id'],
                "wallet_id" => $data['wallet_id'],
                "date_expiry" => $data['date_expiry'],
                "pinfl" => $data['pinfl'],
                "passport" => $data['passport'],
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "middle_name" => $data['middle_name'],
                "status" => $data['status']
            ]
        ]);
    }

    public static function paymentSent($data){
        return UniredGateway::fire([
            "url" => "https://mko.unired.uz/api/contract/create",
            "data" => [
                "pinfl" => $data['pinfl'],
                "passport" => $data['passport'],
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "middle_name" => $data['middle_name'],

                "date" => $data['date'],
                "transaction_id" => $data['transaction_id'],
                "period" => $data['period'],
                "card_number" => $data['card_number'],
                "amount" => $data['amount'],
            ]
        ]);
    }
}
