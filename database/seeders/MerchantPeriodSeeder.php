<?php

namespace Database\Seeders;

use App\Models\Pages\Merchant;
use App\Models\Pages\MerchantPeriod;
use Illuminate\Database\Seeder;

class MerchantPeriodSeeder extends Seeder
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
            MerchantPeriod::create([
                'merchant_id' => $merchant->id,
                'period' => 180,
                'percentage' => 20,
                'status' => 1,
            ]);
            MerchantPeriod::create([
                'merchant_id' => $merchant->id,
                'period' => 270,
                'percentage' => 25,
                'status' => 1,
            ]);
            MerchantPeriod::create([
                'merchant_id' => $merchant->id,
                'period' => 360,
                'percentage' => 30,
                'status' => 1,
            ]);
        }
    }
}
