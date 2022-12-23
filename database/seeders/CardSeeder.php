<?php

namespace Database\Seeders;

use App\Models\Pages\Card;
use App\Services\Luhn;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 1000; $i++){
            $luhn = new Luhn();
            $luhn = $luhn->run();
            Card::create([
                'number' => $luhn['number'],
                'expire' => $luhn['expire'],
                'type' => rand(0,1),
                'owner' => "OK",
                'balance' => 0,
                'hold_amount' => 0,
                'phone' => "+998991234567",
                'token' => Str::random(60),
                'status' => 1,
            ]);
        }
    }
}
