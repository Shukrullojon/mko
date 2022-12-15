<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
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
}
