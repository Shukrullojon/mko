<?php

namespace App\Exports;

use App\Models\Pages\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ReportExport implements FromView
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
        $paymentsQuery = Payment::query();
        if ($this->fromDate && !empty($this->fromDate)) {
            $paymentsQuery->where('date', '>=', $this->fromDate);
        }
        if ($this->toDate && !empty($this->toDate)) {
            $paymentsQuery->where('date', '<=', $this->toDate);
        }
        $payments = $paymentsQuery->orderBy('date', 'DESC')->paginate(4);
//        dd($this->fromDate, $this->toDate, $payments);
        return view('pages.report.exports.reportExport', [
            'payments' => $payments,
        ]);
    }
}
