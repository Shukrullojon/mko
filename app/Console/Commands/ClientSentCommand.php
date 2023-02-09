<?php

namespace App\Console\Commands;

use App\Models\Pages\Client;
use App\Services\ClientSentService;
use App\Services\UniredService;
use Illuminate\Console\Command;

class ClientSentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "clientsent";

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
        /*$clients = Client::where('is_sent', 0)->get();
        foreach ($clients as $client){
            $response = UniredService::clientSent([
                'client_id' => $client->id,
                'client_code' => $client->client_code,
                'application_id' => $client->application_id,
                'wallet_id' => $client->card_id,
                'date_expiry' => $client->date_expiry,
                'pinfl' => $client->pnfl,
                'passport' => $client->passport,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'middle_name' => $client->middle_name,
                'status' => $client->status,
            ]);

            if($response['status']){
                $client->update([
                    'is_sent' => 1,
                    'is_sent_code' => $response['result']['code'] ?? 100,
                ]);
            }
        }
        return 0;*/
    }
}
