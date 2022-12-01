<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Luhn;
use App\Models\Pages\Card;
use App\Models\Pages\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function create($params){
        try{
            $luhn = new Luhn();
            $luhn = $luhn->run();
            $card = DB::transaction(function() use($luhn,$params){
                $card = Card::create([
                    'number' => $luhn['number'],
                    'expire' => $luhn['expire'],
                    'type' => 0,
                    'owner' => strtoupper($params['params']['first_name'])." ".strtoupper($params['params']['last_name']),
                    'balance' => $params['params']['limit'],
                    'hold_amount' => 0,
                    'phone' => $params['params']['phone'],
                    'token' => Str::random(70),
                    'status' => 1,
                ]);

                $client = Client::create([
                    'application_id' => $params['params']['application_id'],
                    'client_code' => $params['params']['client_code'],
                    'card_id' => $card->id,
                    'limit' => $params['params']['limit'],
                    'limit_status' => 1,
                    'used_limit' => 0,
                    'date_expiry'=>$params['params']['date_expiry'],
                    'pnfl' => $params['params']['pnfl'],
                    'passport' => $params['params']['passport'],
                    'first_name' => strtoupper($params['params']['first_name']),
                    'last_name' => strtoupper($params['params']['last_name']),
                    'middle_name' => strtoupper($params['params']['middle_name']),
                    'status' => 1,
                ]);
                return $card;
            });

            return [
                'number' => $card->number,
                'expire' => $card->expire,
                'phone' => $card->phone,
                'balance' => $card->balance,
                'owner' => $card->owner,
                'token' => $card->token,
                'status' => 1,
            ];
        }catch(\Exception $exception){
            return [
                "error" =>[
                    "code" => 424,
                    "message" => [
                        "uz" => $exception->getMessage(),
                        "ru" => $exception->getMessage(),
                        "en" => $exception->getMessage(),
                    ],
                ],
            ];
        }
    }
}
