<?php

namespace App\Console\Commands;

use App\Models\Pages\Card;
use App\Models\Pages\CardTransaction;
use App\Models\Pages\Payment;
use App\Services\CardService;
use Illuminate\Console\Command;

class PaymentUcoinCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "paymentucoin";

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
        $payments = Payment::where('is_ucoin',null)->where('status',1)->get();
        $card = Card::where('type',2)->first();
        foreach ($payments as $payment){
            $debit = CardService::debit([
                'token' => $card->token,
                'amount' => $payment->amount,
            ]);
            if($debit){
                $payment->update([
                    'is_ucoin' => 1,
                ]);
                CardTransaction::create([
                    'sender' => $card->number,
                    'amount' => $payment->amount,
                    'status' => 2,
                    'payment_id' => $payment->id,
                ]);
            }
        }

        return 0;
    }
}
