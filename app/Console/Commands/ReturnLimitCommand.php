<?php

namespace App\Console\Commands;

use App\Models\Pages\Card;
use App\Models\Pages\Client;
use Illuminate\Console\Command;

class ReturnLimitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "returnlimit";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return Limit';

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
    public function handle(){
        $clients = Client::where('created_at','<',date("Y-m-d",strtotime("-1 month")))->get();
        foreach ($clients as $client){
            $client->update([
                'used_limit' => $client->limit - $client->card->balance,
            ]);
            Card::where('id',$client->card->id)->update([
                'balance' => 0,
            ]);
        }
        return 0;
    }
}
