<?php

namespace App\Console;

use App\Http\BatchTransitioner;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            BatchTransitioner::HandleExpiredAuthorizations();
        })->everyFiveMinutes();

        $schedule->call(function () {
            BatchTransitioner::HandleNewTestsDueSoon();
        })->daily()->at("05:10:00");

        $schedule->call(function () {
            BatchTransitioner::HandleRequiredNewTests();
        })->daily()->at("05:15:00");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
