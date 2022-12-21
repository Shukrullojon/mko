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
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function confirm($params)
    {
        $card = Card::where('token', $params['params']['token'])->first();
        $client = Client::where('card_id', $card->id)->first();
        $merchant = Merchant::where('key', $params['params']['key'])->first();
        $period = MerchantPeriod::where('id', $params['params']['period_id'])->where('merchant_id', $merchant->id)->first();
        $account = Account::where('type', 3)->first();
        $accountMko = Account::where('type', 4)->first();
        if (empty($card) or empty($client) or empty($merchant) or empty($period)) {
            return ErrorHelper::error300();
        }

        if ($card->balance < ($params['params']['amount'] + $params['params']['amount'] * ($period->percentage / 100))) {
            return ErrorHelper::error301();
        }

        $payment = Payment::create([
            'client_id' => $client->id,
            'name' => $params['params']['name'],
            'merchant_id' => $merchant->id,
            'period' => $period->period,
            'percentage' => $period->percentage,
            'sender_card' => $card->token,
            'amount' => $params['params']['amount'],
            'percentage_amount' => (($merchant->account->percentage + $account->percentage + $accountMko->percentage) * $params['params']['amount']) / 100,
            'date' => date("Y-m-d"),
            'is_transaction' => 0,
            'status' => 0,
            'tr_id' => Str::uuid(),
        ]);

        try {
            $debit = CardService::debit([
                'token' => $card->token,
                'expire' => $card->expire,
                'amount' => $payment->amount + $payment->percentage_amount,
            ]);
            if ($debit) {
                $credirMerchant = MerchantService::credit([
                    'card_id' => $card->id,
                    'merchant_id' => $merchant->id,
                    'amount' => $payment->amount + $payment->percentage_amount,
                ]);
                $payment->update([
                    'status' => 1,
                ]);
            }
            return [
                'tr_id' => $payment->tr_id
            ];
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
        $payment = Payment::where('tr_id', $params['params']['tr_id'])->where('status',1)->where('is_transaction', 0)->first();
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
        $amount = $payment->amount + $payment->percentage_amount;
        // terminal debit
        $debit = MerchantService::debit([
            'merchant_id' => $payment->merchant_id,
            'amount' => $amount,
        ]);
        if ($debit) {
            $payment->update([
                'status' => 20,
            ]);
            $credit = CardService::credit([
                'token' => $payment->sender_card,
                'amount' => $amount,
            ]);
            if ($credit) {
                $payment->update([
                    'status' => 21,
                ]);
                return [];
            } else {
                $creditTerminal = MerchantService::credit([
                    'merchant_id' => $payment->merchant_id,
                    'amount' => $amount,
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
    }
}
