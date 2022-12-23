<?php

namespace Database\Seeders;

use App\Models\Pages\Account;
use App\Models\Pages\Card;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
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
            Account::create([
                "type" => 1,
                "number" => "20204000100001186001",
                "inn" => "000000000",
                "name" => "Filial name",
                "filial" => "01186",
                "card_id" => $card->id,
                "percentage" => "2",
            ]);
        }


    }
}
