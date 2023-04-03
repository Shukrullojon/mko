<?php

namespace App\Http\Controllers\Pages;

use App\Exports\ExportTransaction;
use App\Exports\ExportWallet;
use App\Http\Controllers\Controller;
use App\Models\Pages\CardTransaction;
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
    /* - - */
    public function partner(Request $request)
    {
        $paymentsQuery = Payment::query();
        if ($request->has('merchant') and $request->merchant) {
            $paymentsQuery->where('merchant_id', $request->merchant);
        }
        if ($request->has('fromDate') and $request->fromDate) {
            $paymentsQuery->where('date', '>=', $request->fromDate);
        }
        if ($request->has('toDate') and $request->toDate) {
            $paymentsQuery->where('date', '<=', $request->toDate);
        }
        $payments = $paymentsQuery->with('merchant:id,name,filial', 'client:id,first_name,middle_name,last_name')->paginate(10);
        return view('pages.report.partner', [
            'payments' => $payments,
        ]);
    }

    public function wallet(Request $request)
    {
        $uc_transactions = DB::table('card_transactions')
            ->select('payments.date', 'payments.tr_id', DB::raw("CONCAT(clients.first_name, ' ', clients.middle_name, ' ', clients.last_name, '// ', merchants.name, '// ') as info"), 'card_transactions.amount as debet', DB::raw('NULL as credit'), 'card_transactions.created_at')
            ->leftJoin('payments','card_transactions.payment_id','=','payments.id')
            ->leftJoin('clients','payments.client_id','=','clients.id')
            ->leftJoin('merchants','payments.merchant_id','=','merchants.id')
            ->whereNotNull('card_transactions.payment_id');

        if ($request->has('fromDate') and $request->fromDate) {
            $uc_transactions->where('date', '>=', $request->fromDate);
        }
        if ($request->has('toDate') and $request->toDate) {
            $uc_transactions->where('date', '<=', $request->toDate);

        }

        $uc_transactions = DB::table('histories')
            ->select('histories.date', 'histories.numberTrans', DB::raw("CONCAT('PAYLATER// ', 'UCOIN// ', histories.purpose) as info"), DB::raw('NULL as debet'), 'histories.credit', 'histories.created_at')
            ->where('histories.status','=',1)
            ->union($uc_transactions)
            ->orderBy('created_at', 'desc');


        if ($request->has('fromDate') and $request->fromDate) {
            $uc_transactions->where('date', '>=', $request->fromDate);
        }
        if ($request->has('toDate') and $request->toDate) {
            $uc_transactions->where('date', '<=', $request->toDate);
        }
        $uc_transactions = $uc_transactions->paginate(10);
<<<<<<< HEAD

=======
//        dd($uc_transactions, $request->fromDate, $request->toDate);
>>>>>>> e9f341b1746d8b1c9013fb7503e25ea1acbb54a5
        return view('pages.report.wallet', [
            'uc_transactions' => $uc_transactions
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
    public function exportTransaction(Request $request)
    {
        if ($request->has('fromDate') and $request->fromDate) {
            $fromDate = $request->fromDate;
        }
        if ($request->has('toDate') and $request->toDate) {
            $toDate = $request->toDate;
        }

        return Excel::download(new ExportTransaction($request->fromDate, $request->toDate), 'report-of-transaction.xlsx');
    }

    public function exportWallet(Request $request)
    {
        if ($request->has('fromDate') and $request->fromDate) {
            $fromDate = $request->fromDate;
        }
        if ($request->has('toDate') and $request->toDate) {
            $toDate = $request->toDate;
        }

        return Excel::download(new ExportWallet($request->fromDate, $request->toDate), 'report-of-wallet.xlsx');
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
