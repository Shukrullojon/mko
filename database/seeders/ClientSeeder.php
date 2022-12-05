<?php

namespace Database\Seeders;

use App\Models\Pages\Account;
use App\Models\Pages\Card;
use App\Models\Pages\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 100; $i++){
            $card = Card::select('id')->inRandomOrder()->first();
            Client::create([
                'application_id' => Str::random(10),
                'client_code' => Str::random(10),
                'card_id' => $card->id,
                'limit' => 0,
                'limit_status' => 0,
                'used_limit' => 0,
                'date_expiry' => date("Y-m-d"),
                'pnfl' => Str::random(14),
                'passport' => Str::random(9),
                'first_name' => Str::random(20),
                'last_name' => Str::random(20),
                'middle_name' => Str::random(20),
                'status' => 1,
            ]);
        }
    }
}
