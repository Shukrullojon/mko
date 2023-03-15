<?php

namespace App\Http\Controllers\Pages;

use App\Exports\ReportExport;
use App\Exports\WalletReportExport;
use App\Http\Controllers\Controller;
use App\Models\Pages\History;
use App\Models\Pages\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transaction(Request $request)
    {
        $paymentsQuery = Payment::query();
        if ($request->has('fromDate') and $request->fromDate) {
            $paymentsQuery->where('date', '>=', $request->fromDate);
        }
        if ($request->has('toDate') and $request->toDate) {
            $paymentsQuery->where('date', '<=', $request->toDate);
        }
        $payments = $paymentsQuery->with('merchant:id,name,filial',
            'client:id,first_name,middle_name,last_name',
            'transactions')->paginate(10);
        return view('pages.report.transaction', [
            'payments' => $payments,
        ]);
    }

    public function wallet(Request $request)
    {
        $filter = '';
        $historiesQuery = History::query();
        if ($request->has('fromDate') and $request->fromDate) {
            $filter = 'filter';
            $historiesQuery->where('date', '>=', $request->fromDate);
        }
        if ($request->has('toDate') and $request->toDate) {
            $filter = 'filter';
            $historiesQuery->where('date', '<=', $request->toDate);
        }
        if ($filter == 'filter') {

            History::select(DB::raw("sum(debit) as debit"),
                DB::raw("sum(credit) as credit")
            );
        }
        $histories = $historiesQuery->paginate(20);
        return view('pages.report.wallet', [
            'histories' => $histories,
            'filter' => $filter
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('pages.report.show', [
            'payment' => Payment::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        if ($request->has('fromDate') and $request->fromDate) {
            $fromDate = $request->fromDate;
        }
        if ($request->has('toDate') and $request->toDate) {
            $toDate = $request->toDate;
        }

        return Excel::download(new ReportExport($request->fromDate, $request->toDate), 'report-of-transaction.xlsx');
    }

    public function exportWallet(Request $request)
    {
        if ($request->has('fromDate') and $request->fromDate) {
            $fromDate = $request->fromDate;
        }
        if ($request->has('toDate') and $request->toDate) {
            $toDate = $request->toDate;
        }

        return Excel::download(new WalletReportExport($request->fromDate, $request->toDate), 'Wallet.xlsx');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
