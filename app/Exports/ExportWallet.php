<?php

namespace App\Exports;

use App\Models\Pages\Payment;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportWallet implements FromView
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
        $uc_transactions = DB::table('card_transactions')
            ->select('payments.date', 'payments.tr_id', DB::raw("CONCAT(clients.first_name, ' ', clients.middle_name, ' ', clients.last_name, '// ', merchants.name, '// ', payments.name) as info"), "payments.amount as debet", 'card_transactions.credit as credit', 'card_transactions.created_at')
            ->leftJoin('payments','card_transactions.payment_id','=','payments.id')
            ->leftJoin('clients','payments.client_id','=','clients.id')
            ->leftJoin('merchants','payments.merchant_id','=','merchants.id')
            ->whereNotNull('card_transactions.payment_id');

        if ($this->fromDate) {
            $uc_transactions->where('date', '>=', $this->fromDate);
        }
        if ($this->toDate) {
            $uc_transactions->where('date', '<=', $this->toDate);
        }

        $uc_transactions = DB::table('histories')
            ->select('histories.date', 'histories.numberTrans', DB::raw("CONCAT('PAYLATER// ', 'UCOIN// ', histories.purpose) as info"), 'histories.debit as debet', 'histories.credit', 'histories.created_at')
            ->where('histories.status','=',1)
            ->union($uc_transactions)
            ->orderBy('created_at', 'desc');


        if ($this->fromDate) {
            $uc_transactions->where('date', '>=', $this->fromDate);
        }
        if ($this->toDate) {
            $uc_transactions->where('date', '<=', $this->toDate);
        }
        if (!$this->fromDate and !$this->toDate) {
            return view('pages.report.exports.export-wallet', [
               'uc_transactions' => $uc_transactions->take(10)->get(),
                'fromDate' => $this->fromDate??date('d-m-Y'),
                'toDate' => $this->fromDate??date('d-m-Y')
            ]);
        }

        $uc_transactions = $uc_transactions->get();
//        dd($uc_transactions, $this->fromDate, $this->toDate);
        return view('pages.report.exports.export-wallet', [
            'uc_transactions' => $uc_transactions,
            'fromDate' => $this->fromDate??date('d-m-Y'),
            'toDate' => $this->fromDate??date('d-m-Y'),
        ]);

    }
}
