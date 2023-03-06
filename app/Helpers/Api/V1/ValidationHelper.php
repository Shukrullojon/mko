<?php

namespace App\Helpers\Api\V1;

class ValidationHelper
{
    public static function check($params){
        if($params['method'] == "login.login"){
            return [
                "params.email" => "required",
                "params.password" => "required",
            ];
        }else if($params['method'] == "client.create"){
            return [
                "params.application_id" => "required",
                "params.client_code" => "required",
                "params.passport" => "required",
                "params.pnfl" => "required",
                "params.phone" => "required",
                "params.limit" => "required|numeric",
                "params.date_expiry" => "required",
                "params.first_name" => "required",
                "params.last_name" => "required",
                "params.middle_name" => "required",
            ];
        }else if($params['method'] == "merchant.period"){
            return [
                "params.key" => "required|exists:merchants,key",
            ];
        }else if($params['method'] == "merchant.schedule"){
            return [
                "params.period_id" => "required|exists:merchant_periods,id",
                "params.amount" => "required",
            ];
        }else if($params['method'] == "payment.confirm"){
            return [
                "params.token" => "required|exists:cards,token",
                "params.key" => "required|exists:merchants,key",
                "params.period_id" => "required|exists:merchant_periods,id",
                "params.amount" => "required|integer|min:1",
            ];
        }else if($params['method'] == "card.info"){
            return [
                "params.token" => "required|exists:cards,token"
            ];
        }else if($params['method'] == "partner.get"){
            return [];
        }else if($params['method'] == "partner.merchant"){
            return [];
        }else if($params['method'] == "account.info"){
            return [
                'params.account' => 'required|size:20'
            ];
        }else if($params['method'] == "payment.cancel"){
            return [
                "params.tr_id" => "required|exists:payments,tr_id"
            ];
        }else if($params['method'] == "merchant.balance"){
            return [
                "params.account" => "required|exists:accounts,number"
            ];
        }else if($params['method'] == "card.card"){
            return [
                "params.token" => "required|exists:cards,token"
            ];
        }else if($params['method'] == "transaction.send"){
            return [
                "params.transaction_id" => "required|exists:transactions,id,type,0,is_sent,0,status,1"
            ];
        }else if($params['method'] == "payment.byCard"){
            return [
                "params.card" => "required|exists:cards,number",
                "params.key" => "required|exists:merchants,key",
                "params.period_id" => "required|exists:merchant_periods,id",
                "params.amount" => "required|numeric"
            ];
        }else if($params['method'] == "payment.byCardConfirm"){
            return [
                "params.tr_id" => "required|exists:payments,tr_id",
                "params.code" => "required|numeric"
            ];
        }else if($params['method'] == "card.getCard"){
            return [
                "params.phone" => "required|string"
            ];
        }else if($params['method'] == "transfer.account"){
            return [
                "params.sender" => "required|exists:cards,token",
                "params.receiver" => "required|exists:accounts,number",
                "params.amount" => "required|integer|min:1",
            ];
        }else if($params['method'] == "transfer.ucoin"){
            return [
                "params.sender" => "required|exists:cards,token",
                "params.receiver" => "required|exists:cards,token",
                "params.amount" => "required|integer|min:1",
            ];
        }else if($params['method'] == "transfer.state"){
            return [
                "params.tr_id" => "required|exists:transfers,uuid",
            ];
        }else{
            return [
                "method" => [
                    "required",
                    "in:login.login,
                    client.create,
                    brand.get,
                    merchant.period,
                    merchant.schedule,
                    payment.confirm,
                    card.info,
                    partner.get,
                    partner.merchant,
                    payment.cancel,
                    merchant.balance,
                    card.card,
                    transaction.send,
                    payment.byCard,
                    payment.byCardConfirm,
                    card.getCard,
                    transfer.account,
                    transfer.ucoin,
                    transfer.state,
                    ",
                ],
            ];
        }

    }
}
