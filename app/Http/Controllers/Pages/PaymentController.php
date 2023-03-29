<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:payment.index'])->only('index');
        $this->middleware(['auth','permission:payment.show'])->only('show');
    }

    public function index(Request $request)
    {
        $payments = Payment::latest()->paginate(20);
        return view('pages.payment.index', [
            'payments' => $payments,
        ]);
    }

    public function show($id){
        $payment = Payment::find($id);
        return view('pages.payment.show',[
            'payment' => $payment
        ]);
    }

    public function cancel($id){
        $payment = Payment::find($id);

        //

        // 1. payment cancel status
        // 2. transactions debit money vs cancel status
        // 3. client return money
        // 4. mko ucoin return money

    }
}
