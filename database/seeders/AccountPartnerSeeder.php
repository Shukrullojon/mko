<?php

namespace Database\Seeders;

use App\Models\Pages\Account;
use App\Models\Pages\Card;
use Illuminate\Database\Seeder;

class AccountPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // account transit
        Account::create([
            "type" => 2,
            "number" => "22640000900001186005",
            "inn" => "203556638",
            "name" => "ТОШКЕНТ Ш., АТ БАНКИ \"УНИВЕРСАЛ БАНК\" МИРОБОД РАКАМЛИ ФИЛИАЛИ",
            "filial" => "01186",

        ]);

        // Mko
        $card = Card::select('id')->inRandomOrder()->first();
        Account::create([
            "type" => 4,
            "number" => "20204000100001186003",
            "inn" => "000000000",
            "name" => "Mko",
            "filial" => "01186",
            "card_id" => $card->id,
            "percentage" => "2",
        ]);

        // ItUnisoft
        $card = Card::select('id')->inRandomOrder()->first();
        Account::create([
            "type" => 3,
            "number" => "20204000100001186002",
            "inn" => "000000000",
            "name" => "ItUnisoft",
            "filial" => "01186",
            "card_id" => $card->id,
            "percentage" => "2",
        ]);

    }
}
