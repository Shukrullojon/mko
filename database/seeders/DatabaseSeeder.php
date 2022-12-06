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
            BrandSeeder::class,
            MerchantSeeder::class,
            MerchantPeriodSeeder::class,
            PaymentSeeder::class,
            UserSeeder::class,
        ]);
    }
}
