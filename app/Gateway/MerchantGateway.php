<?php

namespace App\Gateway;

class MerchantGateway
{
    public static function send($id)
    {

        $ch = curl_init("https://merchant-mko.unired.uz/callback/$id");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                "Accept: application/json",
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(null));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);
        curl_close($ch);
        return json_decode($return,true);
    }
}
