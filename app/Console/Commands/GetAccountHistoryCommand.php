<?php

namespace App\Console\Commands;

use App\Models\Pages\Account;
use App\Models\Pages\Card;
use App\Models\Pages\History;
use App\Services\AbsService;
use App\Services\CardService;
use App\Services\TransactionAccountService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetAccountHistoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "getaccounthistory";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transaction account description';


     /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $account = Account::where('type', 2)->first();
        $history = History::latest()->first();
        $getAccInfo = AbsService::getAccountDetails(['account'=>$account->number]);
        dd($getAccInfo);
        $service = AbsService::getAccountHistory([
            'account' => $account->number,
            'date' => "20.01.2023",
            'filial' => $account->filial,
        ]);
        if (isset($service['result']['responseBody']['response']) and $service['result']['responseBody']['response']) {
            foreach ($service['result']['responseBody']['response'] as $d){
                History::firstOrCreate(
                    [
                        'numberTrans' => $d['numberTrans']
                    ],
                    [
                        'date' => date('Y-m-d', strtotime($d['date'])),
                        'dtAcc' => $d['dtAcc'],
                        'dtAccName' => $d['dtAccName'],
                        'dtMfo' => $d['dtMfo'],
                        'purpose' => $d['purpose'],
                        'debit' => $d['debit'] * 100,
                        'credit' => $d['credit'] * 100,
                        'numberTrans' => $d['numberTrans'],
                        'type' => $d['type'],
                        'ctAcc' => $d['ctAcc'],
                        'ctAccName' => $d['ctAccName'],
                        'ctMfo' => $d['ctMfo'],
                        'status' => 0,
                    ]);
            }
        }

        $creditAmount = History::select(DB::raw("sum(credit) as credit"))->where('status',0)->where('credit','!=',0)->first();
        if(!empty($creditAmount)){
            $cardService = CardService::credit([
                'token' => $account->card->token,
                'amount' => $creditAmount->credit,
            ]);
            if($cardService){
                History::where('status',0)->where('credit','!=',0)->update([
                    'status' => 1,
                ]);
            }
        }
        return 0;
    }
}
