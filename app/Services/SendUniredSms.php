<?php

namespace App\Services;

use PlayMobile\SMS\SmsService;
use PlayMobile\SMS\Models\SmsLog;

class SendUniredSms
{
    public function apply($phone, $content, $tr_id)
    {
        $response = (new SmsService())->send($phone, $content);
        SmsLog::create([
            'phone'    => $phone,
            'message'  => $content,
            'response' => $response,
            'status'   => ($response == 'Request is received') ? SmsLog::STATUS_SUCCESS : SmsLog::STATUS_FAILD,
            'payment_tr_id' => $tr_id
        ]);
        return $response;
    }
}
