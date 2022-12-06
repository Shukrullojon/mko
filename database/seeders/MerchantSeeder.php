<?php

namespace Database\Seeders;

use App\Models\Pages\Account;
use App\Models\Pages\Brand;
use App\Models\Pages\Merchant;
use Illuminate\Database\Seeder;
use App\Services\MobileService;
use Illuminate\Support\Str;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = Brand::get();
        foreach($brands as $brand){
            $account = Account::select('id')->inRandomOrder()->first();
            Merchant::create([
                'brand_id' => $brand->id,
                'key' => Str::random(20),
                'name' => "Filial 1",
                'filial' => "Filial 1",
                'address' => "Address",
                'uzcard_merchant_id' => Str::random(10),
                'uzcard_terminal_id' => Str::random(10),
                'humo_merchant_id' => Str::random(10),
                'humo_terminal_id' => Str::random(10),
                'is_register_humo' => 0,
                'is_register_uzcard' => 0,
                'account_id' => $account->id,
            ]);

            Merchant::create([
                'brand_id' => $brand->id,
                'key' => Str::random(20),
                'name' => "Filial 2",
                'filial' => "Filial 2",
                'address' => "Address",
                'uzcard_merchant_id' => Str::random(10),
                'uzcard_terminal_id' => Str::random(10),
                'humo_merchant_id' => Str::random(10),
                'humo_terminal_id' => Str::random(10),
                'is_register_humo' => 0,
                'is_register_uzcard' => 0,
                'account_id' => $account->id,
            ]);

            Merchant::create([
                'brand_id' => $brand->id,
                'key' => Str::random(20),
                'name' => "Filial 3",
                'filial' => "Filial 3",
                'address' => "Address",
                'uzcard_merchant_id' => Str::random(10),
                'uzcard_terminal_id' => Str::random(10),
                'humo_merchant_id' => Str::random(10),
                'humo_terminal_id' => Str::random(10),
                'is_register_humo' => 0,
                'is_register_uzcard' => 0,
                'account_id' => $account->id,
            ]);
        }
    }
}
