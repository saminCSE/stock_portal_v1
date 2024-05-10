<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Cron\ScreenerScheduleSettingCronController;

class InsertRsiForTodayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'screnner:insert-today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert RSI for today';

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
        // $today = now()->toDateString(); // Get today's date
        // $today = '2022-01-24'; // Get today's date
        Log::info('screnner:insert-today');
        $cronController = new ScreenerScheduleSettingCronController();
        // $cronController->insertRsiForToday($today); // Pass today's date as an argument
        // $this->info("RSI insert for $today completed successfully."); // Include today's date in the success message
        $result = $cronController->insertRsiForToday(); // Pass today's date as an argument
        $this->info("$result"); // Include today's date in the success message
    }
}
