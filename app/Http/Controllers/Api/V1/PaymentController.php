<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Api\V1\ErrorHelper;
use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\Card;
use App\Models\Pages\Client;
use App\Models\Pages\Merchant;
use App\Models\Pages\MerchantPeriod;
use App\Models\Pages\Payment;
use App\Services\CardService;
use App\Services\MerchantService;
use App\Services\SendUniredSms;
use Illuminate\Support\Str;
use PlayMobile\SMS\Models\SmsLog;

class PaymentController extends Controller
{
    public function confirm($params)
    {
        $cardLater = Card::where('type', 2)->first();
        $card = Card::where('token', $params['params']['token'])->first();
        $client = Client::where('card_id', $card->id)->first();
        $merchant = Merchant::where('key', $params['params']['key'])->first();
        $period = MerchantPeriod::where('id', $params['params']['period_id'])->where('merchant_id', $merchant->id)->first();

        if (empty($card) or empty($client) or empty($merchant) or empty($period) or $cardLater->balance < $params['params']['amount']) {
            return ErrorHelper::error300();
        }

        if ($card->balance < ($params['params']['amount'])) {
            return ErrorHelper::error301();
        }

        /*if($params['params']['amount'] < 50000000){
            return ErrorHelper::error302();
        }*/

        $payment = Payment::create([
            'name' => $params['params']['name'] ?? null,
            'client_id' => $client->id,
            'merchant_id' => $merchant->id,
            'period' => $period->period,
            'percentage' => $period->percentage,
            'sender_card' => $card->token,
            'amount' => $params['params']['amount'],
            'date' => date("Y-m-d"),
            'is_transaction' => 0,
            'status' => 0,
            'tr_id' => Str::uuid(),
        ]);

        try {
            $debit = CardService::debit([
                'token' => $card->token,
                'amount' => $payment->amount,
            ]);
            if ($debit) {
                $creditMerchant = MerchantService::credit([
                    'card_id' => $card->id,
                    'merchant_id' => $merchant->id,
                    'amount' => $payment->amount,
                ]);
                if ($creditMerchant) {
                    $payment->update([
                        'status' => 1,
                    ]);
                    return [
                        'tr_id' => $payment->tr_id
                    ];
                } else {
                    $credit = CardService::credit([
                        'token' => $card->token,
                        'amount' => $payment->amount,
                    ]);
                    if ($credit) {
                        $payment->update([
                            'status' => -1,
                        ]);
                    } else {
                        $payment->update([
                            'status' => -5,
                        ]);
                    }
                    return ErrorHelper::error300();
                }
            } else {
                return ErrorHelper::error300();
            }
        } catch (\Exception $e) {
            return [
                'error' => [
                    "code" => 400,
                    "message" => [
                        "uz" => $e->getMessage(),
                        "ru" => $e->getMessage(),
                        "en" => $e->getMessage(),
                    ],
                ],
            ];
        }
    }

    public function cancel($params)
    {
        try {
            $payment = Payment::where('tr_id', $params['params']['tr_id'])->where('status', 1)->first();
            if (empty($payment)) {
                return [
                    'error' => [
                        "code" => 400,
                        "message" => [
                            "uz" => "Tranzaksiyani bekor qilib bo'lmaydi",
                            "ru" => "Транзакция не может быть отменена",
                            "en" => "The transaction cannot be canceled",
                        ],
                    ],
                ];
            }
            // terminal debit
            $debit = MerchantService::debit([
                'merchant_id' => $payment->merchant_id,
                'amount' => $payment->amount,
            ]);
            if ($debit) {
                $payment->update([
                    'status' => 20,
                ]);
                $credit = CardService::credit([
                    'token' => $payment->sender_card,
                    'amount' => $payment->amount,
                ]);
                if ($credit) {
                    $payment->update([
                        'status' => 21,
                    ]);
                    return [];
                } else {
                    $creditTerminal = MerchantService::credit([
                        'merchant_id' => $payment->merchant_id,
                        'amount' => $payment->amount,
                    ]);
                    if ($creditTerminal) {
                        $payment->update([
                            'status' => 0
                        ]);
                    } else {
                        $payment->update([
                            'status' => 22
                        ]);
                    }
                    return [
                        'error' => [
                            'code' => 300,
                            "message" => [
                                "uz" => "Tranzaksiyani bekor qilib bo'lmadi",
                                "ru" => "Транзакция не может быть отменена",
                                "en" => "The transaction cannot be canceled",
                            ],
                        ],
                    ];
                }
            }
        }catch (\Exception $exception){
            return [
                'error' => [
                    "code" => 400,
                    "message" => [
                        "uz" => $exception->getMessage(),
                        "ru" => $exception->getMessage(),
                        "en" => $exception->getMessage(),
                    ],
                ],
            ];
        }
    }

    /* - - */
    public function byCard($params) {
        $card = Card::where('number', $params['params']['card'])->first();
        $client = Client::where('card_id', $card->id)->first();
        $merchant = Merchant::where('key', $params['params']['key'])->first();
        $period = MerchantPeriod::where('id', $params['params']['period_id'])->where('merchant_id', $merchant->id)->first();

        if (empty($card) or empty($client) or empty($merchant) or empty($period)) {
            return ErrorHelper::error300();
        }

        if ($card->balance < ($params['params']['amount'])) {
            return ErrorHelper::error301();
        }
        $payment = Payment::create([
            'name' => $params['params']['name'] ?? null,
            'client_id' => $client->id,
            'merchant_id' => $merchant->id,
            'period' => $period->period,
            'percentage' => $period->percentage,
            'sender_card' => $card->token,
            'amount' => $params['params']['amount'],
            'date' => date("Y-m-d"),
            'is_transaction' => 0,
            'status' => 0,
            'tr_id' => Str::uuid(),
        ]);

        $phone = substr($card->phone, -9);
        $sendsms = SendUniredSms::apply($phone, rand(1000, 9999), $payment->tr_id);

        return [
            'tr_id' => $payment->tr_id
        ];

    }

    /*- - */
    public function byCardConfirm($params) {

        $tr_id = $params['params']['tr_id'];
        $payment = Payment::where('tr_id', $tr_id)->first();
        $sms = SmsLog::where('payment_tr_id', $tr_id)->where('status', 2)->latest()->first();

        $card = Card::where('token', $payment->sender_card)->first();
        $merchant = Merchant::where('id', $payment->merchant_id)->first();

        if ($payment and $sms){
            try {
                $debit = CardService::debit([
                    'token' => $payment->sender_card,
                    'amount' => $payment->amount,
                ]);
                if ($debit) {
                    $creditMerchant = MerchantService::credit([
                        'card_id' => $card->id,
                        'merchant_id' => $merchant->id,
                        'amount' => $payment->amount,
                    ]);
                    if ($creditMerchant) {
                        $payment->update([
                            'status' => 1,
                        ]);
                        $sms->update([
                            'status' => 4
                        ]);
                        return [
                            'tr_id' => $payment->tr_id
                        ];
                    } else {
                        $credit = CardService::credit([
                            'token' => $card->token,
                            'amount' => $payment->amount,
                        ]);
                        if ($credit) {
                            $payment->update([
                                'status' => -1,
                            ]);
                        } else {
                            $payment->update([
                                'status' => -5,
                            ]);
                        }
                        return ErrorHelper::error300();
                    }
                } else {
                    return ErrorHelper::error300();
                }
            } catch (\Exception $e) {
                return [
                    'error' => [
                        "code" => 400,
                        "message" => [
                            "uz" => $e->getMessage(),
                            "ru" => $e->getMessage(),
                            "en" => $e->getMessage(),
                        ],
                    ],
                ];
            }
        }

    }
}
