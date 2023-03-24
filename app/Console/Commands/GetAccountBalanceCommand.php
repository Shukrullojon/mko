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

class GetAccountBalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "getaccountbalance";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get account balance information';

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
<<<<<<< HEAD
        $accounts = Account::get();
        foreach ($accounts as $account){
            $getAccInfo = AbsService::getAccountDetails([
                'account'=>$account->number
            ]);
            
            $account->update([
                'name' => $getAccInfo['data']['responseBody']['nameAcc'],
                'inn' => $getAccInfo['data']['responseBody']['inn'],
            ]);
        }

        dd("qwerty");
=======
>>>>>>> 4434c9949a5de5a7c7a28965b5452c44e7ccc212

        $history = History::where('dtAcc', '22640000900001186005')->latest('date')->orderBy('id', 'DESC')->first();
        $getAccInfo = AbsService::getAccountDetails(['account'=>$history->dtAcc]);
        if (isset($getAccInfo['data']['responseBody']) and $getAccInfo['data']['responseBody']) {
            $history->update([
                'curr_balance' => $getAccInfo['data']['responseBody']['saldo']
            ]);
        }
        return 0;
    }
}
