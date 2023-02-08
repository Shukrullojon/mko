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
                'pinfl' => $payment->client->pnfl ?? "",
                'passport' => $payment->client->passport ?? "",
                'first_name' => $payment->client->first_name ?? "",
                'last_name' => $payment->client->last_name ?? "",
                'middle_name' => $payment->client->middle_name ?? "",
                'date' => $payment->date,
                'transaction_id' => $payment->id,
                'period' => $payment->period,
                'card_number' => $payment->client->card->number ?? "",
                'amount' => $payment->amount,
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
