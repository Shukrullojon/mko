<?php

namespace App\Services;

class GraphicService
{
    public static function done($data){
        # Initial params
        $period = $data['period'];
        $percentage = $data['percentage'];
        $cost = $data['amount'];
        $amount = $data['amount'] + ceil($data['amount']/100*$percentage); // 5 mln so'm tiyinda
        $dailySum = intval($amount/$period); // 1 kunga qancha summa to'g'ri kelishi
        $residue = $amount - ($dailySum*$period); // qoldiq
        $startDate = date('Y-m-d'); // tranzaksiyan bo'lgan sana
        $endDate = date('Y-m-01',strtotime($startDate.' first day of +1 month'));
        $graphic = [];
        $check = 0;
        while ($period > 0){
            //Days in this month
            $days = (strtotime($endDate) - strtotime($startDate)) / 86400;
            if ($days > $period)
                $days = $period;
            $sum = $days * $dailySum;
            // Engi birinchi oyga qoldiqni qo'shib yuborish
            if ($residue > 0){
                $sum += $residue;
                $residue = 0;
            }
            //add data to graphic list
            $graphic[] = [
                'days' => $days,
                //'amount' => price_format($sum),
                'amount' => $sum,
                'month' => date('Y-M',strtotime($startDate))
            ];
            //update initial params for the next cycle
            $period -= $days;
            $startDate = $endDate;
            $endDate = date('Y-m-01',strtotime($startDate.' first day of +1 month'));
        }
        return [
            'amount' => $amount,
            'cost' => $cost,
            'graphic' => $graphic,
        ];
    }
}
