<?php

namespace App\Http\Controllers\Pages;

use App\Exports\ExportCalculatePartner;
use App\Exports\ExportTransaction;
use App\Exports\ExportWallet;
use App\Http\Controllers\Controller;
use App\Models\Pages\CardTransaction;
use App\Models\Pages\History;
use App\Models\Pages\Payment;
use App\Models\Pages\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use function Whoops\Exception\Formatter;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
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
        $payments = $paymentsQuery->with('merchant',
            function ($query) {
                $query->select('*')->with('account');
            })->with('client:id,first_name,middle_name,last_name',
            'transactions')->paginate(10);
        return view('pages.report.transaction', [
            'payments' => $payments,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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
            ->select('payments.date as date', 'payments.tr_id', DB::raw("CONCAT(clients.first_name,' ',clients.middle_name,' ',clients.last_name) as sender_name"),
                'merchants.name as recipient', 'payments.name as purpose_text', "payments.amount as debet", 'card_transactions.credit as credit', 'card_transactions.created_at')
            ->leftJoin('payments', 'card_transactions.payment_id', '=', 'payments.id')
            ->leftJoin('clients', 'payments.client_id', '=', 'clients.id')
            ->leftJoin('merchants', 'payments.merchant_id', '=', 'merchants.id')
            ->whereNotNull('card_transactions.payment_id');

        if ($request->has('fromDate') and $request->fromDate) {
            $uc_transactions->whereDate('card_transactions.updated_at', '>=', $request->fromDate);
        }
        if ($request->has('toDate') and $request->toDate) {
            $uc_transactions->whereDate('card_transactions.updated_at', '<=', $request->toDate);
        }

        $uc_transactions = DB::table('histories')
            ->select('histories.date as date', 'histories.numberTrans', DB::raw("'Paylater' as sender_name"), DB::raw("'Ucoin card' as recipient"),
                'histories.purpose as purpose_text', 'histories.debit as debet', 'histories.credit', 'histories.created_at')
            ->where('histories.status', '=', 1)
            ->union($uc_transactions)
            ->orderBy('created_at', 'desc');

        if ($request->has('fromDate') and $request->fromDate) {
            $uc_transactions->whereDate('histories.date', '>=', $request->fromDate);
        }
        if ($request->has('toDate') and $request->toDate) {
            $uc_transactions->whereDate('histories.date', '<=', $request->toDate);
        }

        $uc_transactions = $uc_transactions->paginate(10);
        return view('pages.report.wallet', [
            'uc_transactions' => $uc_transactions
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function calculate_partner(Request $request)
    {
        $transactions = DB::table('transactions')
            ->select('transactions.updated_at', 'transactions.amount')
//                DB::raw("SUM(transactions.amount)*0.985 as paid_to_merchant"),
//                DB::raw("SUM(transactions.amount)*0.015 as commission_bank"))
            ->leftJoin('payments', 'transactions.payment_id', '=', 'payments.id')
            ->leftJoin('merchants', 'payments.merchant_id', '=', 'merchants.id')
            ->leftJoin('brands', 'merchants.brand_id', '=', 'brands.id')
            ->where('transactions.is_sent', 1)
            ->where('transactions.type', 0)->paginate(20);
        if ($request->has($request->fromDate) and $request->fromDate) {
            $transactions = $transactions->where('transactions.updated_at', '>=', strtotime("$request->fromDate"));
        }
        if ($request->has($request->toDate) and $request->toDate) {
            $transactions = $transactions->where('transactions.updated_at', '<=', "$request->toDate%");
        }
        dd($transactions, $request->fromDate, $request->toDate);

        $transactions = $transactions->groupBy('transactions.receiver_card')
            ->paginate(20);

        return view('pages.report.calculate-partner', [
            'transactions' => $transactions
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
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
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportTransaction(Request $request)
    {
        if ($request->has('fromDate') and $request->fromDate) {
            $fromDate = $request->fromDate;
        }
        if ($request->has('toDate') and $request->toDate) {
            $toDate = $request->toDate;
        }

        return Excel::download(new ExportTransaction($fromDate ?? null, $toDate ?? null), date('d.m.Y') . '_report-transaction.xlsx');
    }

    public function exportWallet(Request $request)
    {
        if ($request->has('fromDate') and $request->fromDate) {
            $fromDate = $request->fromDate;
        }
        if ($request->has('toDate') and $request->toDate) {
            $toDate = $request->toDate;
        }

        return Excel::download(new ExportWallet($fromDate ?? null, $toDate ?? null), date('d.m.Y') . '_report-wallet.xlsx');
    }

    public function exportCalculatePartner(Request $request)
    {
        $val = Validator::make($request->all(), [
            'fromDate' => 'required',
            'toDate' => 'required'
        ]);
        if ($val->fails()) {
            return back();
        }
        return Excel::download(new ExportCalculatePartner($request->fromDate, $request->toDate), date('d.m.Y') . '_calculate-partner.xlsx');
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
