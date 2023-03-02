<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\Transaction;
use Illuminate\Http\Request;

class LaterController extends Controller
{
    public function index()
    {
        $account = Account::where('type', 4)->first();
        $transactions = Transaction::where('account_id', $account->id)->latest()->paginate(20);
        return view('pages.paylater.index', [
            'transactions' => $transactions,
        ]);
    }
}
