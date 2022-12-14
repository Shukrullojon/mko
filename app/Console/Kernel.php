<?php

namespace App\Console;

use App\Console\Commands\ClientSentCommand;
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
        /*TransactionCommand::class,
        TransactionAccountCommand::class,*/
        //ClientSentCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
        /*$schedule->command('transaction')->everyFiveMinutes();
        $schedule->command("transaction:account")->everyFiveMinutes();*/
        //$schedule->command("")->everyFiveMinutes();
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
