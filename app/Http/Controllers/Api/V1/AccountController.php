<?php

namespace App\Http\Controllers\Api\V1;

use App\Gateway\AbsGateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function info($data)
    {
        try {
            $account = AbsGateway::fire('POST', 'api/v1/bank', [
                "jsonrpc" => "2.0",
                "id" => rand(10000, 99999),
                "method" => "iabs.account.get.account.details",
                "params" => [
                    "account" => $data['params']['account'],
                    "code_filial" => '01186',
                    "id" => 123
                ]
            ]);
            if (isset($account['data']['responseBody']) and $account['data']['code'] == 0) {
                return [
                    'account' => $account['data']['responseBody']['account'],
                    'nameAcc' => $account['data']['responseBody']['nameAcc'],
                    'saldo' => $account['data']['responseBody']['saldo']
                ];
            } else {
                return [
                    'error' => [
                        'code' => 404,
                        'msg' => 'Данные не найдены'
                    ]
                ];
            }
        }catch (\Exception $exception){
            return $this->errorException($exception);
        }
    }

    public function errorException($exception){
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
