<?php

namespace App\Console\Commands;

use App\Models\Pages\Account;
use App\Models\Pages\Card;
use App\Models\Pages\History;
use App\Services\AbsService;
use App\Services\CardService;
use App\Services\TransactionAccountService;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DBCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "db-create";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'bla';

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
        $acc = Card::all()->toArray();
        foreach ($acc as $a) {
            $a['card_id']=$a['id'];
            unset($a['id']);
            DB::connection('mysql_clon')->table('ucoin_cards')->insert($a);
        }
        return 0;
    }
}
