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
            ->select('payments.date', 'payments.tr_id', DB::raw("CONCAT(clients.first_name,' ',clients.middle_name,' ',clients.last_name) as sender_name"), 'merchants.name as recipient', 'payments.name as purpose_text', "payments.amount as debet", 'card_transactions.credit as credit', 'card_transactions.created_at')
            ->leftJoin('payments','card_transactions.payment_id','=','payments.id')
            ->leftJoin('clients','payments.client_id','=','clients.id')
            ->leftJoin('merchants','payments.merchant_id','=','merchants.id')
            ->whereNotNull('card_transactions.payment_id');
//        dd($uc_transactions->get());
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
            $payment = Payment::latest()->first();
            $this->fromDate = $payment['date'];
            $this->toDate = $payment['date'];
            /* -- */
            $uc_transactions = DB::table('card_transactions')
                ->select('histories.date', 'histories.numberTrans', 'histories.dtAcc as sender_name', 'histories.dtAccName as recipient', 'histories.purpose as purpose_text', 'histories.debit as debet', 'histories.credit', 'histories.created_at')
                ->leftJoin('payments','card_transactions.payment_id','=','payments.id')
                ->leftJoin('clients','payments.client_id','=','clients.id')
                ->leftJoin('merchants','payments.merchant_id','=','merchants.id')
                ->whereNotNull('card_transactions.payment_id');

            $uc_transactions->whereBetween('date', [$this->fromDate, $this->toDate]);

            $uc_transactions = DB::table('histories')
                ->select('histories.date', 'histories.numberTrans', DB::raw("CONCAT('PAYLATER// ', 'UCOIN// ', histories.purpose) as info"), 'histories.debit as debet', 'histories.credit', 'histories.created_at')
                ->where('histories.status','=',1)
                ->union($uc_transactions)
                ->orderBy('created_at', 'desc');

            $uc_transactions->whereBetween('date', [$this->fromDate, $this->toDate]);

            /* - - */
            return view('pages.report.exports.export-wallet', [
                'uc_transactions' => $uc_transactions->get()
                ]);
        }

        $uc_transactions = $uc_transactions->get();
        return view('pages.report.exports.export-wallet', [
            'uc_transactions' => $uc_transactions,
        ]);

    }
}
