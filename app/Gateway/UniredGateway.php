<?php

namespace App\Gateway;

class UniredGateway
{
    public static function fire($data)
    {
        $ch = curl_init($data['url']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                "Accept: application/json",
                "Authorization: Bearer mq21GX4GJ612v6CCdSTU0hbakJSuc31DuC6UN38JW4vUWxe7ul4Imvf52tcmZjo0P0ejxZ",
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data['data']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);
        curl_close($ch);
        return json_decode($return,true);
    }
}
