<?php

namespace App\Services;

use App\Gateway\MobileGateway;

class MobileService
{
    public static function partners(){
        return MobileGateway::fire([
            "method"=>"get.partners"
        ]);
    }

    public static function branches($data){
        return MobileGateway::fire([
            "method"=>"get.branches",
            "params"=>[
                "partner_id"=>$data['partner_id'],
            ]
        ]);
    }
}
