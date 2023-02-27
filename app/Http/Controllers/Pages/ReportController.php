<?php

namespace App\Http\Controllers\Pages;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Pages\Payment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paymentsQuery = Payment::query();
        if ($request->has('fromDate') and $request->fromDate) {
            $paymentsQuery->where('date', '>=', $request->fromDate);
        }
        if ($request->has('toDate') and $request->toDate) {
            $paymentsQuery->where('date', '<=', $request->toDate);

        }
        $payments = $paymentsQuery->with('merchant:id,name',
            'client:id,first_name,middle_name,last_name',
            'transactions')->paginate(10);
        return view('pages.report.index', [
            'payments' => $payments,
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $fromDate = '';
        $toDate = '';
        if ($request->has('fromDate') and $request->fromDate) {
            $fromDate = $request->fromDate;
        }
        if ($request->has('toDate') and $request->toDate) {
            $toDate = $request->toDate;
        }

        return Excel::download(new ReportExport($fromDate, $toDate), 'reportExcel.xlsx');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
