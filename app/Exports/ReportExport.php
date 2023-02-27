<?php

namespace App\Exports;

use App\Models\Pages\Payment;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ReportExport implements FromView
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
        $payments = $paymentsQuery->with('merchant:id,name',
            'client:id,first_name,middle_name,last_name',
            'transactions')->get();

        return view('pages.report.exports.reportExport', [
            'payments' => $payments
        ]);
    }
}
