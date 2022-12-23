<?php

namespace App\Console\Commands;

use App\Services\TransactionAccountService;
use Illuminate\Console\Command;

class TransactionAccountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "transaction:account";

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
        TransactionAccountService::transaction();
        return 0;
    }
}
