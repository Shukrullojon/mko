<?php

namespace Database\Seeders;

use App\Models\Pages\Account;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CardSeeder::class,
            ClientSeeder::class,
            AccountSeeder::class,
            AccountPartnerSeeder::class,
            BrandSeeder::class,
            MerchantSeeder::class,
            MerchantPeriodSeeder::class,
            MerchantTerminalSeeder::class,
            PaymentSeeder::class,
            UserSeeder::class,
        ]);
    }
}
