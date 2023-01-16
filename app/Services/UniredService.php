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
            "url" => "https://mko.unired.uz/api/transaction/create",
            "data" => [
                "name" => $data['name'],
                "tr_id" => $data['tr_id'],
                "client_id" => $data['client_id'],
                "merchant_id" => $data['merchant_id'],
                "period" => $data['period'],
                "percentage" => $data['percentage'],
                "amount" => $data['amount'],
                "wallet_number" => $data['wallet_number'],
                "date" => $data['date'],
                "status" => $data['status']
            ]
        ]);
    }
}
