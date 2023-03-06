<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\Transaction;
use App\Models\Pages\TransactionAccount;
use App\Services\AbsService;
use App\Services\CardService;
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

    public function sent($id)
    {
        $transaction = Transaction::find($id);
        $account = Account::where('type', 2)->first();
        if ($transaction->account->type == 4) {
            $abs = AbsService::transaction([
                'type' => "101",
                'sender_account' => $account->number,
                'sender_code_filial' => $account->filial,
                'sender_tax' => $account->inn,
                'sender_name' => $account->name,
                'recipient_account' => $transaction->account->number,
                'recipient_code_filial' => $transaction->account->filial,
                'recipient_tax' => $transaction->account->inn,
                'recipient_name' => $transaction->account->name,
                'purpose' => [
                    "code" => "00668",
                    "name" => $transaction->payment->merchant->brand->purpose . "перевод (дата: " . date("Y-m-d H:i:s") . ") " . "} ID{V" . str_pad($transaction->id, 12, '0', STR_PAD_LEFT) . "V}",
                ],
                'amount' => $transaction->amount,
            ]);
            if (isset($abs['status']) and $abs['status']) {
                $debit = CardService::debit([
                    'token' => $transaction->receiver_card,
                    'amount' => $transaction->amount,
                ]);
                $transaction->update([
                    'is_sent' => 1,
                ]);
                TransactionAccount::create([
                    'transaction_id' => $transaction->id,
                    'sender_id' => $account->id,
                    'receiver_id' => $transaction->account->id,
                    'amount' => $transaction->amount,
                    'transactionId' => $abs['data']['responseBody']['createdDocuments'][0]['transactionId'],
                    'status' => 1,
                ]);
                return redirect()->route('laterIndex')->with("success","Success");
            }
        }
        return redirect()->route('laterIndex')->with("error","Error Transaction");
    }
}
