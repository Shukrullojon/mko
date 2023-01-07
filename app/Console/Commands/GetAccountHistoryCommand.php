<?php

namespace App\Console\Commands;

use App\Models\Pages\Account;
use App\Models\Pages\Card;
use App\Models\Pages\History;
use App\Services\AbsService;
use App\Services\TransactionAccountService;
use Illuminate\Console\Command;

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
        $card = Card::where('type', 3)->first();
        $account = Account::where('card_id', $card->id)->first();
        $history = History::latest()->first();
        $service = AbsService::getAccountHistory($account->number, '06.12.2022');
//        dd($service['result']['responseBody']['response']);
        if (isset($service['result']['responseBody']['response']) and $service['result']['responseBody']['response']){
            History::saver($service['result']['responseBody']['response']);
        }
        return 12;
    }
}
