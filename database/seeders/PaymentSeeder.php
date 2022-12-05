<?php

namespace Database\Seeders;

use App\Models\Pages\Client;
use App\Models\Pages\Merchant;
use App\Models\Pages\MerchantPeriod;
use App\Models\Pages\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 100; $i++){
            $client = Client::inRandomOrder()->first();
            $merchant = Merchant::select('id')->inRandomOrder()->first();
            $period = MerchantPeriod::where('merchant_id',$merchant->id)->inRandomOrder()->first();
            
            $cost = rand(100000000,500000000);
            Payment::create([
                'client_id' => $client->id,
                'merchant_id' => $merchant->id,
                'period' => $period->period,
                'percentage' => $period->percentage,
                'sender_card' => $client->card->number,
                'cost' => $cost,
                'amount' => $cost + $cost * ($period->percentage / 100),
                'date' => date("Y-m-d"),
                'is_transaction' => 0,
                'status' => 1,
                'tr_id' => Str::uuid(),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
