<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pages\CardTransaction;
use App\Services\CardService;
use Illuminate\Http\Request;
use App\Services\Luhn;
use App\Models\Pages\Card;
use App\Models\Pages\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function create($params)
    {
        try {
            /*$cardLater = Card::where('type', 2)->first();
            if ($cardLater->balance < $params['params']['limit']) {
                return [
                    "error" => [
                        "code" => 424,
                        "message" => [
                            "uz" => "Yetarli mablag' mavjud emas",
                            "ru" => "Yetarli mablag' mavjud emas",
                            "en" => "There are insufficient funds",
                        ],
                    ],
                ];
            }*/

            $client = Client::where('passport', $params['params']['passport'])
                //->where('pnfl', $params['params']['pnfl'])
                ->first();

            if (empty($client)) {
                try {
                    $luhn = new Luhn();
                    $luhn = $luhn->run();
                    $card = DB::transaction(function () use ($luhn, $params) {
                        $card = Card::create([
                            'number' => $luhn['number'],
                            'expire' => $luhn['expire'],
                            'type' => 0,
                            'owner' => strtoupper($params['params']['first_name']) . " " . strtoupper($params['params']['last_name']),
                            'balance' => 0,
                            'hold_amount' => 0,
                            'phone' => $params['params']['phone'],
                            'token' => Str::random(70),
                            'status' => 0,
                        ]);

                        $client = Client::create([
                            'application_id' => $params['params']['application_id'],
                            'client_code' => $params['params']['client_code'],
                            'card_id' => $card->id,
                            'limit' => $params['params']['limit'],
                            'limit_status' => 0,
                            'used_limit' => 0,
                            'date_expiry' => $params['params']['date_expiry'],
                            'pnfl' => $params['params']['pnfl'],
                            'passport' => $params['params']['passport'],
                            'first_name' => strtoupper($params['params']['first_name']),
                            'last_name' => strtoupper($params['params']['last_name']),
                            'middle_name' => strtoupper($params['params']['middle_name']),
                            'status' => 1,
                        ]);
                        return $card;
                    });

                    // debit
                    /*$tr = CardTransaction::create([
                        'sender' => $cardLater->number,
                        'receiver' => $card->number,
                        'amount' => $params['params']['limit'],
                        'status' => 0,
                    ]);*/
                    /*$debit = CardService::debit([
                        'token' => $cardLater->token,
                        'amount' => $params['params']['limit'],
                    ]);*/
                    /*$credit = CardService::credit([
                        'token' => $card->token,
                        'amount' => $params['params']['limit'],
                    ]);*/
                    /*if ($credit) {
                        /*$tr->update([
                            'status' => 2
                        ]);*/
                    /*$card->update([
                        'status' => 1,
                        'balance' => $params['params']['limit'],
                    ]);*/
                    return [
                        'number' => $card->number,
                        'expire' => $card->expire,
                        'phone' => $card->phone,
                        'balance' => (int)$card->balance,
                        'owner' => $card->owner,
                        'token' => $card->token,
                        'status' => 1,
                    ];

                    /*if ($debit) {
                        $tr->update([
                            "status" => 1
                        ]);

                    }*/

                    return [
                        "error" => [
                            "code" => 424,
                            "message" => [
                                "uz" => "Limit ajratishda xatolik",
                                "ru" => "Limit ajratishda xatolik",
                                "en" => "Limit ajratishda xatolik",
                            ],
                        ],
                    ];
                } catch (\Exception $exception) {
                    return [
                        "error" => [
                            "code" => 424,
                            "message" => [
                                "uz" => $exception->getMessage(),
                                "ru" => $exception->getMessage(),
                                "en" => $exception->getMessage(),
                            ],
                        ],
                    ];
                }
            } else {
                $client->update([
                    'client_code' => '1234',
                ]);
                return [
                    'number' => $client->card->number,
                    'expire' => $client->card->expire,
                    'phone' => $client->card->phone,
                    'balance' => $client->card->balance,
                    'owner' => $client->card->owner,
                    'token' => $client->card->token,
                    'status' => $client->card->status,
                ];
            }
        } catch (\Exception $exception) {
            return $this->errorException($exception);
        }
    }

    public function errorException($exception)
    {
        return [
            'error' => [
                'code' => 500,
                'message' => [
                    'uz' => $exception->getMessage(),
                    'ru' => $exception->getMessage(),
                    'en' => $exception->getMessage(),
                ],
            ],
        ];
    }
}
