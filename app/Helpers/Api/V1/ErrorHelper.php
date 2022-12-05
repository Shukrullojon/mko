<?php

namespace App\Helpers\Api\V1;

class ErrorHelper
{

    /**
     */
    public static function error300():array{
        return [
            'error' => [
                'code' => 300,
                "message" => [
                    "uz" => "To'lovda xatolik",
                    "ru" => "To'lovda xatolik",
                    "en" => "To'lovda xatolik",
                ],
            ],
        ];
    }

    public static function error301():array{
        return [
            'error' => [
                'code' => 301,
                "message" => [
                    "uz" => "Pul yetarli emas",
                    "ru" => "Не хватает денег",
                    "en" => "Do not have enough money",
                ],
            ],
        ];
    }
}
