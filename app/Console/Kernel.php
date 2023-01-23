<?php

namespace App\Console;

use App\Console\Commands\ClientSentCommand;
use App\Console\Commands\GetAccountHistoryCommand;
use App\Console\Commands\PaymentSentCommand;
use App\Console\Commands\TransactionAccountCommand;
use App\Console\Commands\TransactionCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        TransactionCommand::class,
        ClientSentCommand::class,
        PaymentSentCommand::class,
        GetAccountHistoryCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
        $schedule->command('transaction')->everyMinute();
        //$schedule->command("transaction:account")->everyFiveMinutes();
        $schedule->command("clientsent")->everyMinute();
        $schedule->command("paymentsent")->everyMinute();
        $schedule->command("getaccounthistory")->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
