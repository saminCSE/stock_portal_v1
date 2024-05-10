<?php

namespace App\Console;

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
        Commands\AddBlockTransactionCommand::class,
        // Commands\DatabankEodCommand::class,
        Commands\MarketScheduleSettingCommand::class,
        Commands\UpdatePreviousDateRsiCommand::class,
        Commands\InsertRsiForTodayCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('block-transaction:add')->dailyAt('14:45');

        //$schedule->command('DataBankEod:add')->dailyAt('16:00');

        // $schedule->command('MarketSchedulerSetting:add')->dailyAt('16:00');
        $schedule->command('MarketSchedulerSetting:add')->monthly();

        // Command to update or insert RSI for the previous date
        // $schedule->command('screnner:update-previous-date')->monthly();

        // Command to insert RSI for today
        $schedule->command('screnner:insert-today')->dailyAt('14:45');
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
