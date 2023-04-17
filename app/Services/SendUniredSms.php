<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use PlayMobile\SMS\SmsService;
use App\Models\Pages\SmsLog;

class SendUniredSms
{
    public function apply($phone, $content, $tr_id)
    {
        $response = (new SmsService())->send($phone, $content);
        SmsLog::create([
            'phone'    => $phone,
            'message'  => Hash::make($content),
            'response' => $response,
            'status'   => ($response == 'Request is received') ? SmsLog::STATUS_SUCCESS : SmsLog::STATUS_FAILD,
            'payment_tr_id' => $tr_id
        ]);
        return $response;
    }
}
