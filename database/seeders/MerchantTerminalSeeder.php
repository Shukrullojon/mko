<?php

namespace Database\Seeders;

use App\Models\Pages\Merchant;
use App\Models\Pages\MerchantTerminal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MerchantTerminalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $merchants = Merchant::get();
        foreach($merchants as $merchant){
            MerchantTerminal::create([
                'merchant_id' => $merchant->id,
                'merchant' => Str::random(8),
                'terminal' => Str::random(8),
                'balance' => 0,
                'status' => 1,
            ]);
        }
    }
}
