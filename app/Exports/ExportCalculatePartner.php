<?php

namespace App\Exports;

use App\Models\Pages\Payment;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportCalculatePartner implements FromView
{

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate  = $toDate;
    }
//    public function collection()
//    {
//        return  Payment::all();
//    }
    /**
     * @return \Illuminate\Support\Facades\View
     */

    public function view(): View
    {
        $transactions = DB::table('transactions')
            ->select('merchants.filial as merchant_name', 'brands.purpose as brand_purpose',
                'payments.amount as payment_sum', 'transactions.updated_at as date',
                DB::raw("SUM(transactions.amount) as commission_merchant"),
                DB::raw("SUM(transactions.amount)*0.985 as paid_to_merchant"),
                DB::raw("SUM(transactions.amount)*0.015 as commission_bank"))
            ->leftJoin('payments','transactions.payment_id','=','payments.id')
            ->leftJoin('merchants','payments.merchant_id','=','merchants.id')
            ->leftJoin('brands','merchants.brand_id','=','brands.id')
            ->where('transactions.is_sent',1)
            ->where('transactions.type',0);
//            ->whereBetween('transactions.updated_at',[$request->dateBegin, $request->dateClose])
//            ->groupBy('transactions.receiver_card');

        if ($this->fromDate) {
            $transactions = $transactions->where('date', '>=', "$this->fromDate%");
        }

        if ($this->toDate) {
            $transactions = $transactions->where('date', '<=', "$this->toDate%");
        }

        $transactions = $transactions->groupBy('transactions.receiver_card')->get();
        return view('pages.report.exports.export-calculate-partner', [
            'transactions' => $transactions,
        ]);

    }
}
