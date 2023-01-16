<?php

namespace App\Console\Commands;

use App\Models\Pages\Payment;
use App\Services\UniredService;
use Illuminate\Console\Command;

class PaymentSentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "paymentsent";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payments = Payment::where('is_sent', null)->get();
        foreach ($payments as $payment){
            $response = UniredService::paymentSent([
                'name' => $payment->name,
                'tr_id' => $payment->tr_id,
                'client_id' => $payment->client_id,
                'merchant_id' => $payment->merchant_id,
                'period' => $payment->period,
                'percentage' => $payment->percentage,
                'amount' => $payment->amount,
                'wallet_number' => $payment->client->card->number ?? "",
                'date' => $payment->date,
                'status' => $payment->status,
            ]);
            if($response['status']){
                $payment->update([
                    'is_sent' => 1,
                    'is_sent_code' => $response['result']['code'] ?? 100
                ]);
            }
        }
        return 0;
    }
}
