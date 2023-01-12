<?php

namespace App\Services;

use App\Gateway\ClientSentGateway;

class ClientSentService
{
    public static function sent($data)
    {
        return ClientSentGateway::fire([
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
        ]);
    }
}
