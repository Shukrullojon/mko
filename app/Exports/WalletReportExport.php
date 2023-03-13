<?php

namespace App\Exports;

use App\Models\Pages\Payment;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class WalletReportExport implements FromView
{

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate  = $toDate;
    }
    /**
    * @return \Illuminate\Support\Facades\View
    */

    public function view(): View
    {
        $paymentsQuery = Payment::query();
        if ($this->fromDate && !empty($this->fromDate)) {
            $paymentsQuery->where('date', '>=', $this->fromDate);
        }
        if ($this->toDate && !empty($this->toDate)) {
            $paymentsQuery->where('date', '<=', $this->toDate);
        }
        $payments = $paymentsQuery->paginate(20);
        dd($this->fromDate, $this->toDate, $payments);
        return view('pages.report.export-transaction', [
            'payments' => $payments,
        ]);
    }
}
