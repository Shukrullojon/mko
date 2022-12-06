<?php

namespace Database\Seeders;

use App\Models\Pages\Account;
use App\Models\Pages\Brand;
use App\Models\Pages\Merchant;
use Illuminate\Database\Seeder;
use App\Services\MobileService;

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
            $lists = MobileService::branches([
                'partner_id' => $brand->brand_id,
            ]);

            foreach($lists['data'] as $value){
                $account = Account::select('id')->inRandomOrder()->first();
                Merchant::create([
                    'brand_id' => $brand->id,
                    'name' => $value['filial'],
                    'key' => $value['key'],
                    'account_id' => $account->id,
                ]);
            }
        }
    }
}
