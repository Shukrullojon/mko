<?php
/*
 * Unisoft Group Copyright (c)  2021.
 *
 * Created by Fatulloyev Shukrullo
 * Please contact before making any changes
 *
 * Tashkent, Uzbekistan
 */

namespace App\Gateway;


class AbsGateway
{
    public static function fire($method, $url, $data)
    {
        $url = 'http://192.168.202.250/'.$url;

        $curl = curl_init();

        switch($method){
            case 'GET':
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, TRUE);
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'PATCH':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        }
        if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, $url);
        //later implement more productive

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTVlNWZjNGVmZjk5NTM0ODkxZTk5ZWUzZTg0YTc1OTkzNGEzOWQwZWFmMGVlNjYwZWRiMGMzYTljMWY5MzBkYmFmMjJkZTgyY2I3NTEyYjkiLCJpYXQiOjE2NzAzMjUyNzcsIm5iZiI6MTY3MDMyNTI3NywiZXhwIjoxNzAxODYxMjc3LCJzdWIiOiIzNiIsInNjb3BlcyI6W119.RXeWGTxATp2yHMoehejs3EiyIXMKitajQYSNPB71LrrEOy9SM0moFnDPAerf_6N67OCx2MWo16SB_DjPgQqh133g-G8id-VWtzD1t_QMdkw9-ttOifY_Dk9TQKVNyWJAiV3kddLmDTyytU6H968FeznTDT0zE5o0Y3f1gC52z4EhYmD6gjyNygmqG2IUnbJeRQRq-vjYTkfoRPt1F7YXbCGXoNe1EbmLMGtA0BTJla1JomunagXKKl52zRt-jQpTUrnKSNAG0nIyGQu3IIIb3AjXkwJ0OWNlHJAU2sDymJ0iUYwbqBO9wQJRAqSLTBsjwjlwMn__gUdwMFw2yNumTd2L3MKtG3KrigC16DjxPTdrIrSgcQqYIniGyjiPmPQTryLaagA9NkISaRAesbKGyYvZ_f6CctyZpieXjqEa2SaaVY4Fd808AQfWW1wx2zMovgCp42gfthDnZQXU2pBXGGdqs_I0FrTXk6SjMrly0vTe5OE6q21pJo-akRPUxeUTNL_gCoz1wJU4yLk1xNDTZQU1ZesD4YBSfUYrXDR2GzDl1efVU85Cs-VwjFQVi5AJFiGCJL1JtQKAOQXshAg9Hg5dECV6x3hKoDSmuq6zWhU-zQf4EMR62FsyPBRFu1OmAaMPwSJwd5kEBgc-YrcWyoWr8P94YSRt2Y76FbJPRBY";
        $header = [
            'token:'.$token,
            'Content-Type:application/json',
            'Accept:application/json',
            'requestId:' . time() . rand(100, 1000)
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }
}
